<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{User, Product, Category};

class ProductController extends Controller
{
    //---Liste des produits
    public function product_all_view(Request $request)
    {
        $products = Product::orderBy('name', 'ASC')->get();

        $param = [
          "title" => config('global.products'),
          "pIndex" => "product.all",
          "products" => $products
        ];

        return view('product.all', $param);
    }

    //---Ajout de produit vue
    public function product_new_view()
    {
        $categories = Category::orderBy('name', 'ASC')->get();

        $param = [
          "title" => "Nouveau ".config('global.product'),
          "pIndex" => "product.new",
          "categories" => $categories
        ];

        return view('product.new', $param);
    }

    //---Ajout de produit
    public function product_new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'hasStock' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoryId = null;
        if($request->categoryId && is_numeric($request->categoryId)){
            $categoryId = $request->categoryId;
        }
        elseif ($request->categoryNew && trim($request->categoryNew)!="") {
            $Category = Category::where('name', $request->categoryNew)->first();
            if($Category){
                $categoryId = $Category->id;
            }
            else{
                $Category = Category::create([
                    'name' => $request->categoryNew
                ]);
                $Category->save();
                $categoryId = $Category->id;
            }
        }

        //---Vérifier l'existance du produit
        $Product = Product::where('name', $request->name)->first();
        if($Product){
            $request->session()->flash('ess-msg', "Le produit ".$request->name." existe déjà");
            return redirect()->back();
        }

        $Product = Product::create([
            'hasStock' => $request->hasStock,
            'name' => $request->name,
            'qte' => $request->qte,
            'price' => $request->price,
            'categoryId' => $categoryId
        ]);
        if($request->file('img')){
            $file = $request->file('img');
            $filename = 'prod-' . $Product->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(config('global.image_product'), $filename);

            $Product->img = $filename;
        }
        $Product->save();

        $request->session()->flash('ess-msg', "Le ".config('global.product')." à été ajouté");
        return redirect()->back();
    }


    //---Information sur un produit
    public function product_infos_view(Request $request, $productId)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $Product = Product::where('id', $productId)->first();
        if($Product == null) redirect()->route('product.all');

        $param = [
          "title" => config('global.product'),
          "pIndex" => "product.infos",
          "categories" => $categories,
          "Product" => $Product
        ];

        return view('product.infos', $param);
    }

    //---Modification de produit de produit
    public function product_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'hasStock' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //---Vérifier l'existance du produit
        $Product = Product::where('name', $request->name)
            ->where('id', '!=', $request->productId)
            ->first();
        if($Product){
            $request->session()->flash('ess-msg', "Le ".config('global.product')." ".$request->name." existe déjà");
            return redirect()->back();
        }

        $categoryId = null;
        if($request->categoryId && is_numeric($request->categoryId)){
            $categoryId = $request->categoryId;
        }
        elseif ($request->categoryNew && trim($request->categoryNew)!="") {
            $Category = Category::where('name', $request->categoryNew)->first();
            if($Category){
                $categoryId = $Category->id;
            }
            else{
                $Category = Category::create([
                    'name' => $request->categoryNew
                ]);
                $Category->save();
                $categoryId = $Category->id;
            }
        }

        $Product = Product::where('id', $request->productId)->first();
        $Product->hasStock = $request->hasStock;
        $Product->name = $request->name;
        $Product->qte = $request->qte;
        $Product->price = $request->price;
        $Product->categoryId = $categoryId;

        if($request->file('img')){
            $file = $request->file('img');
            $filename = 'prod-' . $Product->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(config('global.image_product'), $filename);

            $Product->img = $filename;
        }

        $Product->save();

        $request->session()->flash('ess-msg', "Le ".config('global.product')." à été modifié");
        return redirect()->back();
    }

}
