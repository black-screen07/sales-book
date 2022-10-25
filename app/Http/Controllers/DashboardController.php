<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{User, Product, Supplying, Sale};

class DashboardController extends Controller
{
    protected $redirectTo = '/login';

    public function index()
    {
        $products = Product::orderBy('name', 'ASC')->get();

        $startHour = date('Y-m-d 00:00:00');
        $endHour = date('Y-m-d 23:59:59');
        $Sales = Sale::where('dateS', '>=', $startHour)
            ->where('dateS', '<=', $endHour)
            ->orderBy('dateS', 'DESC')->orderBy('id', 'DESC')
            ->get();

        //---Montant des ventes de la journé
        $SalesAmount = 0;
        foreach ($Sales as $key => $Sale) {
            //---Si le client payé le montant de son achat ou a payé plus on garde le prix total
            if($Sale->tt == $Sale->cash || $Sale->tt < $Sale->cash){
                $SalesAmount += $Sale->tt;
            }
            //---S'il à payé moins on récupère son cash
            else {
                $SalesAmount += $Sale->cash;
            }
        }

        //---Liste de vente à crédit (où le client doit)
        $SalesOwning = collect([]);
        foreach ($Sales as $key => $Sale) {
            if(($Sale->tt - $Sale->cash) > 0){
                $SalesOwning->push($Sale);
            }
        }

        $Supplyings = Supplying::orderBy('dateS', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $param = [
          "title" => "Tableau de bord",
          "pIndex" => "dashboard",
          "products" => $products,
          "Sales" => $Sales,
          "SalesAmount" => $SalesAmount,
          "Supplyings" => $Supplyings,
          "SalesOwning" => $SalesOwning
        ];

        return view('dashboard', $param);
    }
}
