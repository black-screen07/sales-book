<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use App\Model\{User, Product, Category, Sale, Customer};

class SaleController extends Controller
{
    //---Vue nouvelle vente
    public function sale_new_view(Request $request)
    {
        //---les produit déjà selectionnés pour la vente
        $tabSale = [];
        if(session()->has('sale')){
            foreach (session()->get('sale') as $key => $p) {
                array_push($tabSale, $key);
            }
        }

        //---Dernières ventes
        $startHour = date('Y-m-d 00:00:00');
        $endHour = date('Y-m-d 23:59:59');
        $Sales = Sale::where('dateS', '>=', $startHour)
        ->where('dateS', '<=', $endHour)
        ->orderBy('id', 'DESC')
        ->limit(3)->get();

        $Customers = Customer::orderBy('fullName', 'ASC')->get();

        $Products = Product::whereNotIn('id', $tabSale)
            ->orderBy('name', 'ASC')
            ->get();

        $param = [
            "title" => "Caisse",
            "pIndex" => "sale.new",
            "Products" => $Products,
            "Customers" => $Customers,
            "Sales" => $Sales
        ];

        return view('sale.new', $param);
    }


    //---Ajouter un produit à la vente Modale
    public function sale_product_modal(Request $request, $productId)
    {
        $Product = Product::where('id', $productId)->first();

        $saleQte = 0;
        if(session()->has('sale.'.$request->productId )){
            $p = session()->get('sale.'.$productId );
            $saleQte = $p->saleQte;
        }

        $param = [
          "Product" => $Product,
          "saleQte" => $saleQte
        ];

        return view('sale.modal.product', $param);
    }


    //---Ajouter et modifier un produit de la vente
    public function sale_product_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric',
            'qte' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $request->session()->flash('ess-msg', config('global.error_reload'));
            return redirect()->route('sale.new');
        }

        $Product = Product::where('id', $request->productId)->first();
        if($Product==null){
            $request->session()->flash('ess-msg', config('global.error_reload'));
        }

        $Product->saleQte = $request->qte;

        session(['sale.'.$request->productId => $Product]);

        return redirect()->route('sale.new');
    }

    //---Retirer un produit de la vente
    public function sale_product_remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $request->session()->flash('ess-msg', config('global.error_reload'));
            return redirect()->route('sale.new');
        }

        if(session()->has('sale.'.$request->productId )){
            session()->forget('sale.'.$request->productId );
        }

        return redirect()->route('sale.new');
    }

    //---Enregistrer la vente
    public function sale_new(Request $request)
    {
        if(!$request->cash || ($request->cash && $request->cash<0)) $request->cash = 0;

        //---Cheick customer exitance
        $customerId = null;
        if($request->customerId){
            $customerId = $request->customerId;
        }
        else{
            if($request->phone){
                $request->fullName = $request->fullName ? $request->fullName : "";
                $customer = Customer::where('phone', $request->phone)->first();
                if($customer!=null) {
                    $customerId = $customer->id;
                }
                else{
                    $Customer = Customer::create([
                        'fullName' => $request->fullName,
                        'phone' => $request->phone
                    ]);
                    $Customer->save();
                    $customerId = $Customer->id;
                }
            }
            elseif($request->fullName){
                $Customer = Customer::create([
                    'fullName' => $request->fullName
                ]);
                $Customer->save();
                $customerId = $Customer->id;
            }
        }

        $Sale = Sale::create([
            'tt' => $request->tt,
            'cash' => $request->cash,
            'userId' => Auth::user()->id,
            'customerId' => $customerId
        ]);
        $Sale->save();

        foreach (session()->get('sale') as $key => $product) {
            $Sale->products()->syncWithoutDetaching([
                $product->id => [
                    'qte'=>$product->saleQte,
                    'price'=>$product->price
                ]
            ]);

            $Product_ = Product::where('id', $product->id)->first();
            $Product_->qte -= $product->saleQte;
            $Product_->save();
        }

        if(session()->has('sale')){
            session()->forget('sale');
        }  
        
        return redirect()->route('sale.all');
    }

    //---Annuler la vente
    public function sale_cancel(Request $request)
    {
        if(session()->has('sale')){
            session()->forget('sale');
        }

        return redirect()->route('sale.new');
    }

    //---Toutes les ventes
    public function sale_all_view(Request $request)
    {
        //---Start date
        if($request->startDate){
            $sd = dateDbFormat($request->startDate);
            $startDate = date("$sd 00:00:00");
        }
        else{
            $m = date('m');
            $startDate = date("Y-$m-01 00:00:00");
        }
        //---End date
        if($request->endDate){
            $sd = dateDbFormat($request->endDate);
            $endDate = date("$sd 23:59:59");
        }
        else{
            $endDate = date("Y-m-d 23:59:59");
        }

        $Sales = Sale::where('dateS', '>=', $startDate)
            ->where('dateS', '<=', $endDate)
            ->orderBy('dateS', 'DESC')
            ->get();

        $param = [
          "title" => "Ventes",
          "pIndex" => "sale.all",
          "Sales" => $Sales,
          "startDate" => $startDate,
          "endDate" => $endDate
        ];

        return view('sale.all', $param);
    }

    //
    public function sale_infos_view(Request $request, $saleId)
    {
        $Sale = Sale::where('id', $saleId)->first();
        if($Sale==null) return redirect()->route("sale.all");

        $param = [
          "title" => "Vente",
          "pIndex" => "sale.infos",
          "Sale" => $Sale,
        ];

        return view('sale.infos', $param);
    }

    //---Modifier le prix d'une vente
    public function sale_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saleId' => 'required|numeric',
            'cash' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Sale = Sale::where('id', $request->saleId)->first();
        $Sale->cash += $request->cash;
        $Sale->save();

        $request->session()->flash('ess-msg', "Le prix de la vente a été mis à jour");
        return redirect()->back();
    }

    //---Suprimé une vente
    public function sale_remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saleId' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Sale = Sale::where('id', $request->saleId)->first();
        foreach ($Sale->products as $key => $product) {
            $product->qte += $product->pivot->qte;
            $product->save();
        }
        $Sale->delete();

        $request->session()->flash('ess-msg', "La vente a été suprimer");
        return redirect()->route('sale.all');
    }
}
