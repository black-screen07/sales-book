<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{User, Customer, Supplying, Sale, Category, Charge};

class ConfigController extends Controller
{
    public function config_all_view()
    {
        $Categories = Category::orderBy('name', 'ASC')->get();
        $Charges = Charge::orderBy('name', 'ASC')->get();
        $Customers = Customer::orderBy('fullName', 'ASC')->get();

        $param = [
          "title" => "Configuration",
          "pIndex" => "config.all",
          "Categories" => $Categories,
          "Charges" => $Charges,
          "Customers" => $Customers
        ];

        return view('config.all', $param);
    }


    //---Modifier une categorie de produit
    public function config_category_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|numeric',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //---Vérifier l'existance de la catégorie
        $Category = Category::where('name', $request->name)
            ->where('id', '!=', $request->categoryId)
            ->first();
        if($Category){
            $request->session()->flash('ess-msg', "La catégorie ".$request->name." existe déjà");
            return redirect()->back();
        }

        $Category = Category::where('id', $request->categoryId)->first();
        if($Category){
            $Category->name = $request->name;
            $Category->save();
        }

        $request->session()->flash('ess-msg', "La catégorie à été modifiée");
        return redirect()->back();
    }


    //---Suprimer une categorie de produit
    public function config_category_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Category = Category::where('id', $request->categoryId)->first();
        if($Category){
            $Category->delete();
        }

        $request->session()->flash('ess-msg', "La catégorie à été suprimée");
        return redirect()->back();
    }

    //---Modifier une charge de produit
    public function config_charge_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chargeId' => 'required|numeric',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //---Vérifier l'existance de la charge
        $charge = Charge::where('name', $request->name)
            ->where('id', '!=', $request->chargeId)
            ->first();
        if($charge){
            $request->session()->flash('ess-msg', "La charge ".$request->name." existe déjà");
            return redirect()->back();
        }

        $charge = Charge::where('id', $request->chargeId)->first();
        if($charge){
            $charge->name = $request->name;
            $charge->save();
        }

        $request->session()->flash('ess-msg', "La charge à été modifiée");
        return redirect()->back();
    }


    //---Suprimer une charge de produit
    public function config_charge_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chargeId' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $charge = Charge::where('id', $request->chargeId)->first();
        if($charge){
            $request->session()->flash('ess-msg', "La charge est liée à des coût veuillez suprimer ces coût");
            return redirect()->back();
        }
        else{
            $charge->delete();
        }

        $request->session()->flash('ess-msg', "La charge à été suprimée");
        return redirect()->back();
    }

    //---Modifier un client
    public function config_customer_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customerId' => 'required|numeric',
            'fullName' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('id', $request->customerId)->first();
        if($customer){
            $customer->fullName = $request->fullName;
            $customer->phone = $request->phone;
            $customer->save();
        }

        $request->session()->flash('ess-msg', "Le client à été modifié");
        return redirect()->back();
    }


    //---Suprimer un client
    public function config_customer_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customerId' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('id', $request->customerId)->first();
        $customer->delete();

        $request->session()->flash('ess-msg', "Le client à été suprimé");
        return redirect()->back();
    }
}
