<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Model\{Supplying, Product, Supplier};

class SupplyingController extends Controller
{
    //---Liste des approvisionnement
    public function supplying_all_view(Request $request)
    {
        $Supplyings = Supplying::orderBy('dateS', 'DESC')->get();

        $param = [
          "title" => "Produits",
          "pIndex" => "supplying.all",
          "Supplyings" => $Supplyings
        ];

        return view('supplying.all', $param);
    }

    //---Ajout de produit vue
    public function supplying_new_view()
    {
        $Suppliers = Supplier::orderBy('fullName', 'ASC')->get();

        $param = [
          "title" => "Nouvel Approvisionnement",
          "pIndex" => "supplying.new",
          "Suppliers" => $Suppliers
        ];

        return view('supplying.new', $param);
    }

    //---Ajout de d'approvissionment
    public function supplying_new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateS' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplierId = null;
        if($request->supplierId && is_numeric($request->supplierId)){
            $supplierId = $request->supplierId;
        }
        elseif ($request->supplierNew && trim($request->supplierNew)!="") {
            $supplier = Supplier::where('fullName', $request->supplierNew)->first();
            if($supplier){
                $supplierId = $supplier->id;
            }
            else{
                $supplier = Supplier::create([
                    'fullName' => $request->supplierNew
                ]);
                $supplier->save();
                $supplierId = $supplier->id;
            }
        }

        $request->dateS = dateDbFormat($request->dateS);

        $Supplying = Supplying::create([
            'deliverySheetCode' => $request->deliverySheetCode,
            'dateS' => $request->dateS,
            'comment' => $request->comment,
            'price' => $request->price,
            'userId' => Auth::user()->id,
            'supplierId' => $supplierId
        ]);
        $Supplying->save();


        return redirect()->route('supplying.infos', [$Supplying->id]);

        $request->session()->flash('ess-msg', "Le produit à été enregistré");
        return redirect()->back();
    }

    //---Infos sur un approvisionnement, ajout et modification des produits
    public function supplying_infos_view(Request $request, $supplyingId)
    {
        if(!$supplyingId) redirect()->route('supplying.all');
        $Supplying = Supplying::where('id', $supplyingId)->first();
        if($Supplying == null) redirect()->route('supplying.all');

        $Suppliers = Supplier::orderBy('fullName', 'ASC')->get();

        $productsIdTable = $Supplying->products->pluck('id');

        $Products = Product::
            whereNotIn('id', $Supplying->products->pluck('id'))
            ->orderBy('name', 'ASC')->get();

        $param = [
          "title" => "Approvisionnement",
          "pIndex" => "supplying.infos",
          "Supplying" => $Supplying,
          "Products" => $Products,
          "Suppliers" => $Suppliers
        ];

        return view('supplying.infos', $param);
    }


    //---Modifier un approvisionnement
    public function supplying_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplyingId' => 'required|numeric',
            'dateS' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplierId = null;
        if($request->supplierId && is_numeric($request->supplierId)){
            $supplierId = $request->supplierId;
        }
        elseif ($request->supplierNew && trim($request->supplierNew)!="") {
            $supplier = Supplier::where('fullName', $request->supplierNew)->first();
            if($supplier){
                $supplierId = $supplier->id;
            }
            else{
                $supplier = Supplier::create([
                    'fullName' => $request->supplierNew
                ]);
                $supplier->save();
                $supplierId = $supplier->id;
            }
        }

        $request->dateS = dateDbFormat($request->dateS);

        $Supplying = Supplying::where('id', $request->supplyingId)->first();

        $Supplying->deliverySheetCode = $request->deliverySheetCode;
        $Supplying->dateS = $request->dateS;
        $Supplying->comment = $request->comment;
        $Supplying->price = $request->price;
        $Supplying->userId = Auth::user()->id;
        $Supplying->supplierId = $supplierId;
        $Supplying->save();

        $request->session()->flash('ess-msg', "L'approvisionnement a été modifié");
        return redirect()->back();
    }


    //---Ajouter un produit à un approvisionnement
    public function supplying_product_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplyingId' => 'required|numeric',
            'productId' => 'required|numeric',
            'qte' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Supplying = Supplying::where('id', $request->supplyingId)->first();
        $Supplying->products()->syncWithoutDetaching([
                $request->productId => ['qte'=>$request->qte]
            ]);

        $Product = Product::where('id', $request->productId)->first();
        $Product->qte += $request->qte;
        $Product->save();

        $request->session()->flash('ess-msg', "Le produit à été ajouté");
        return redirect()->back();
    }


    //---Modifier la quantité d'un prodtuit de l'approvisionnement
    public function supplying_product_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplyingId' => 'required|numeric',
            'productId' => 'required|numeric',
            'qte' => 'required|numeric',
            'currentQte' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //---
        $newQte = $request->qte - $request->currentQte;

        $Supplying = Supplying::where('id', $request->supplyingId)->first();
        $Supplying->products()->syncWithoutDetaching([
                $request->productId => ['qte'=>$request->qte]
            ]);

        $Product = Product::where('id', $request->productId)->first();
        $Product->qte += $newQte;
        $Product->save();

        $request->session()->flash('ess-msg', "La quantité du produit à été modifiée");
        return redirect()->back();
    }


    //---Suprimer un prodtuit de l'approvisionnement
    public function supplying_product_remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplyingId' => 'required|numeric',
            'productId' => 'required|numeric',
            'qte' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Supplying = Supplying::where('id', $request->supplyingId)->first();
        $Supplying->products()->detach([
                $request->productId
            ]);

        $Product = Product::where('id', $request->productId)->first();
        $Product->qte -= $request->qte;
        $Product->save();

        $request->session()->flash('ess-msg', "Le produit à été retiré");
        return redirect()->back();
    }
}
