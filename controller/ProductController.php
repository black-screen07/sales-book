<?php
namespace controller;

use vendor\Auth;
use vendor\Redirect;
use model\{User, Product, Category};


/**
 * ProductController
 */
class ProductController
{

    function __construct()
    {
        Auth::isLogOut();
    }

    //---Liste des produits
    public function product_all_view()
    {
        $products = Product::all();

        $param = [
          "title" => "Produits",
          "pIndex" => "product.all",
          "products" => $products
        ];

        return _view('product.all', $param);
    }


    //---Ajout de produit vue
    public function product_new_view()
    {
        $categories = Category::all();

        $param = [
          "title" => "Nouveau Produit",
          "pIndex" => "product.new",
          "categories" => $categories
        ];

        return _view('product.new', $param);
    }


    //---Ajout de produit
    public function product_new_save()
    {
        if(!$_POST['name']) {
            Redirect::back();
        }
        if(!$_POST['price'] || ($_POST['price'] && !is_numeric($_POST['price'])) ) {
            Redirect::back();
        }

        $categoryId = null;
        if($_POST['categoryId'] && is_numeric($_POST['categoryId'])){
            $categoryId = $_POST['categoryId'];
        }
        elseif ($_POST['categoryNew'] && trim($_POST['categoryNew'])!="") {
            $categoryId = $_POST['categoryNew'];
        }

        $add = Product::add($_POST['name'], $_POST['price'], $categoryId);

        echo ($add);
    }
}
