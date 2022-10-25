<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Model\{User, Product, Supplying, Sale, Category, ChargeCost};

class RepportController extends Controller
{

    public function repport_infos_view(Request $request)
    {
        $yearSelected = $request->yearSelected ? $request->yearSelected : date('Y');
        $monthSelected = $request->monthSelected ? $request->monthSelected : date('m');

        $startDate = date("$yearSelected-$monthSelected-01");
        $endDate = date("Y-m-t", strtotime($startDate));

        //---ventes
        $Sales = Sale::where('dateS', '>=', $startDate)
            ->where('dateS', '<=', $endDate)
            ->orderBy('dateS', 'DESC')
            ->get();
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

        $categories = [];
        $products = [];
        $du = 0;
        foreach ($Sales as $key => $Sale) {
            foreach ($Sale->products as $key => $product) {
                //---Categorie
                if (isset($categories[$product->categoryId])) {
                    $categories[$product->categoryId]['qte'] += $product->pivot->qte;
                    $categories[$product->categoryId]['price'] += $product->pivot->price * $product->pivot->qte;
                } else {
                    $categories[$product->categoryId]['cat'] = $product->category ? $product->category : "Aucune catégorie";
                    $categories[$product->categoryId]['qte'] = $product->pivot->qte;
                    $categories[$product->categoryId]['price'] = $product->pivot->price * $product->pivot->qte;
                }
                //---Produits
                if (isset($products[$product->id])) {
                    $products[$product->id]['qte'] += $product->pivot->qte;
                    $products[$product->id]['price'] += $product->pivot->price * $product->pivot->qte;
                } else {
                    $products[$product->id]['prod'] = $product;
                    $products[$product->id]['qte'] = $product->pivot->qte;
                    $products[$product->id]['price'] = $product->pivot->price * $product->pivot->qte;
                }
            }


            if($Sale->tt > $Sale->cash){
                $du += ($Sale->tt - $Sale->cash);
            }
        }

        $categories = collect($categories)->sortByDesc('qte');
        $products = collect($products)->sortByDesc('qte');

        //---Approvisionnement
        $Supplyings = Supplying::where('dateS', '>=', $startDate)
            ->where('dateS', '<=', $endDate)
            ->orderBy('dateS', 'DESC')
            ->get();

        //---Charge
        $ChargeCosts = ChargeCost::where('year', $yearSelected)
            ->where('month', $monthSelected)
            ->get()
            ->sortBy('charge.name');

        $param = [
          "title" => "Rapport",
          "pIndex" => "repport.infos",
          "monthSelected" => $monthSelected,
          "yearSelected" => $yearSelected,
          "Sales" => $Sales,
          "SalesAmount" => $SalesAmount,
          "Supplyings" => $Supplyings,
          "ChargeCosts" => $ChargeCosts,
          "categories" => $categories,
          "products" => $products,
          "du" => $du,
        ];

        return view('repport.infos', $param);
    }
}
