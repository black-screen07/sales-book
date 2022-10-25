<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//---Login
Route::get('/', 'LoginController@index');
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login')->name('login');
Route::post('logout', 'LoginController@logout')->name('logout');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth:user']], function () {
    //---Dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    //---Sale
    Route::get('sale/new', 'SaleController@sale_new_view')->name('sale.new');
    Route::post('sale/new', 'SaleController@sale_new')->name('sale.new');
    Route::get('sale/cancel', 'SaleController@sale_cancel')->name('sale.cancel');
    Route::get('sale/product/modal/{productId}', 'SaleController@sale_product_modal')->name('sale.product.modal');
    Route::post('sale/product/add', 'SaleController@sale_product_add')->name('sale.product.add');
    Route::get('sale/product/remove', 'SaleController@sale_product_remove')->name('sale.product.remove');
    Route::get('sale/all', 'SaleController@sale_all_view')->name('sale.all');
    Route::post('sale/all', 'SaleController@sale_all_view')->name('sale.all');
    Route::get('sale/infos/{saleId}', 'SaleController@sale_infos_view')->name('sale.infos')->where('saleId', '[0-9]+');
    Route::post('sale/update', 'SaleController@sale_update')->name('sale.update');
    Route::get('sale/remove', 'SaleController@sale_remove')->name('sale.remove');
});


Route::group(['middleware' => ['auth:user', 'CheckLevelAdmin']], function () {

    //---Product
    Route::get('product/all', 'ProductController@product_all_view')->name('product.all');
    Route::get('product/new', 'ProductController@product_new_view')->name('product.new');
    Route::post('product/new', 'ProductController@product_new')->name('product.new');
    Route::get('product/infos/{productId}', 'ProductController@product_infos_view')->name('product.infos')->where('productId', '[0-9]+');
    Route::post('product/update', 'ProductController@product_update')->name('product.update');

    //---Supplying
    Route::get('supplying/all', 'SupplyingController@supplying_all_view')->name('supplying.all');
    Route::get('supplying/new', 'SupplyingController@supplying_new_view')->name('supplying.new');
    Route::post('supplying/new', 'SupplyingController@supplying_new')->name('supplying.new');
    Route::get('supplying/infos/{supplyingId}', 'SupplyingController@supplying_infos_view')->name('supplying.infos')->where('supplyingId', '[0-9]+');
    Route::post('supplying/update', 'SupplyingController@supplying_update')->name('supplying.update');
    Route::post('supplying/product/add', 'SupplyingController@supplying_product_add')->name('supplying.product.add');
    Route::post('supplying/product/update', 'SupplyingController@supplying_product_update')->name('supplying.product.update');
    Route::get('supplying/product/remove', 'SupplyingController@supplying_product_remove')->name('supplying.product.remove');

    //---Charge
    Route::get('chargeCost/all', 'ChargeController@chargeCost_all_view')->name('chargeCost.all');
    Route::post('chargeCost/all', 'ChargeController@chargeCost_all_view')->name('chargeCost.all');
    Route::get('chargeCost/new', 'ChargeController@chargeCost_new_view')->name('chargeCost.new');
    Route::post('chargeCost/new', 'ChargeController@chargeCost_new')->name('chargeCost.new');
    Route::get('chargeCost/infos/{chargeCostId}', 'ChargeController@chargeCost_infos_view')->name('chargeCost.infos')->where('chargeCostId', '[0-9]+');
    Route::post('chargeCost/update', 'ChargeController@chargeCost_update')->name('chargeCost.update');
    Route::get('chargeCost/remove', 'ChargeController@chargeCost_remove')->name('chargeCost.remove');

    //---Repport
    Route::get('repport/infos', 'RepportController@repport_infos_view')->name('repport.infos');
    Route::post('repport/infos', 'RepportController@repport_infos_view')->name('repport.infos');

    //---User
    Route::get('user/all', 'UserController@user_all_view')->name('user.all');
    Route::get('user/new', 'UserController@user_new_view')->name('user.new');
    Route::post('user/new', 'UserController@user_new')->name('user.new');
    Route::get('user/infos/{userId}', 'UserController@user_infos_view')->name('user.infos')->where('userId', '[0-9]+');
    Route::post('user/update', 'UserController@user_update')->name('user.update');
    Route::get('user/remove', 'UserController@user_remove')->name('user.remove');

    //---Customer
    Route::get('customer/all', 'CustomerController@user_all_view')->name('customer.all');
    Route::get('customer/new', 'CustomerController@user_new_view')->name('customer.new');
    Route::post('customer/new', 'CustomerController@user_new')->name('customer.new');
    Route::get('customer/infos/{customerId}', 'CustomerController@user_infos_view')->name('customer.infos')->where('customerId', '[0-9]+');
    Route::post('customer/update', 'CustomerController@user_update')->name('customer.update');
    Route::get('customer/remove', 'CustomerController@user_remove')->name('customer.remove');

    //---Configuration
    Route::get('config/all', 'ConfigController@config_all_view')->name('config.all');
    Route::post('config/category/update', 'ConfigController@config_category_update')->name('config.category.update');
    Route::get('config/category/delete', 'ConfigController@config_category_delete')->name('config.category.delete');
    Route::post('config/charge/update', 'ConfigController@config_charge_update')->name('config.charge.update');
    Route::get('config/charge/delete', 'ConfigController@config_charge_delete')->name('config.charge.delete');
    Route::post('config/customer/update', 'ConfigController@config_customer_update')->name('config.customer.update');
    Route::get('config/customer/delete', 'ConfigController@config_customer_delete')->name('config.customer.delete');
});
