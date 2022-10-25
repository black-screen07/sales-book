<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{User, Product, Supplying, Sale, Charge, ChargeCost};

class ChargeController extends Controller
{

    public function chargeCost_all_view(Request $request)
    {
        $yearSelected = $request->yearSelected ? $request->yearSelected : date('Y');
        $monthSelected = $request->monthSelected ? $request->monthSelected : date('m');

        //---Charge
        $ChargeCosts = ChargeCost::where('year', $yearSelected)
            ->get()
            ->sortBy('charge.name');

        if($request->monthSelected!="all"){
            $ChargeCosts = $ChargeCosts->where('month', $monthSelected);
        }


        $param = [
          "title" => "Charges",
          "pIndex" => "chargeCost.all",
          "monthSelected" => $monthSelected,
          "yearSelected" => $yearSelected,
          "ChargeCosts" => $ChargeCosts,
        ];

        return view('charge.all', $param);
    }

    //
    public function chargeCost_new_view(Request $request)
    {
        $Charges = Charge::orderBy('name', 'ASC')->get();
        $yearSelected = date('Y');
        $monthSelected = date('m');

        $param = [
          "title" => "Nouvelle Charge",
          "pIndex" => "chargeCost.new",
          "Charges" => $Charges,
          "monthSelected" => $monthSelected,
          "yearSelected" => $yearSelected,
        ];

        return view('charge.new', $param);
    }

    //---Ajout de charge (coût)
    public function chargeCost_new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|numeric',
            'month' => 'required',
            'amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $chargeId = null;
        if($request->chargeId && is_numeric($request->chargeId)){
            $chargeId = $request->chargeId;
        }
        elseif ($request->chargeNew && trim($request->chargeNew)!="") {
            $charge = Charge::where('name', $request->chargeNew)->first();
            if($charge){
                $chargeId = $charge->id;
            }
            else{
                $charge = Charge::create([
                    'name' => $request->chargeNew
                ]);
                $charge->save();
                $chargeId = $charge->id;
            }
        }
        if($chargeId==null){
            $request->session()->flash('ess-msg', "Veuillez définir la charge");
            return redirect()->back();
        }

        $ChargeCost = ChargeCost::create([
            'year' => $request->year,
            'month' => $request->month,
            'amount' => $request->amount,
            'chargeId' => $chargeId
        ]);
        $ChargeCost->save();

        $request->session()->flash('ess-msg', "La charge à été enregistrée");
        return redirect()->route('chargeCost.all');
    }

    //---Suprimer une charge (coût)
    public function chargeCost_remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chargeCostId' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $request->session()->flash('ess-msg', config('global.error_reload'));
            return redirect()->back();
        }

        $ChargeCost = ChargeCost::where('id', $request->chargeCostId)->first();
        $ChargeCost->delete();

        $request->session()->flash('ess-msg', "La charge à été retirée");
        return redirect()->route('chargeCost.all');
    }

    //---information une charge (coût)
    public function chargeCost_infos_view(Request $request, $chargeCostId)
    {
        $ChargeCost = ChargeCost::where('id', $chargeCostId)->first();
        $Charges = Charge::orderBy('name', 'ASC')->get();

        $param = [
            "title" => "Charge",
            "pIndex" => "chargeCost.infos",
            "ChargeCost" => $ChargeCost,
            "Charges" => $Charges,
          ];

          return view('charge.infos', $param);
    }

    //---Modification de charge (coût)
    public function chargeCost_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chargeCostId' => 'required|numeric',
            'year' => 'required|numeric',
            'month' => 'required',
            'amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $chargeId = null;
        if($request->chargeId && is_numeric($request->chargeId)){
            $chargeId = $request->chargeId;
        }
        elseif ($request->chargeNew && trim($request->chargeNew)!="") {
            $charge = Charge::where('name', $request->chargeNew)->first();
            if($charge){
                $chargeId = $charge->id;
            }
            else{
                $charge = Charge::create([
                    'name' => $request->chargeNew
                ]);
                $charge->save();
                $chargeId = $charge->id;
            }
        }

        $ChargeCost = ChargeCost::where('id', $request->chargeCostId)->first();
        if($ChargeCost!=null){

        }

        $ChargeCost->year = $request->year;
        $ChargeCost->month = $request->month;
        $ChargeCost->amount = $request->amount;
        $ChargeCost->chargeId = $chargeId;
        $ChargeCost->save();

        $request->session()->flash('ess-msg', "La charge à été modifiée");
        return redirect()->back();
    }
}
