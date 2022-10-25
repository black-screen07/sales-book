<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hasStock', 
        'name',
        'price',
        'qte',
        'img',
        'categoryId',
        'enabled',
    ];

    /**
     * Get image.
     */
    public function getImg()
    {
        if ($this->img && file_exists(public_path('storage/'.config('global.image_product').'/'.$this->img))) {
            $img = asset('storage/'.config('global.image_product').'/'.$this->img);
        } else {
            $img = asset(config('global.default_image_product'));
        }

        return $img;
    }

    /**
     * Verifé si c'est un produit avec stock
     *
     * @return void
     */
    function hasStock()
    {
        if($this->hasStock=1) return true;
        else return false;
    }


    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'categoryId', 'id');
    }

    public function sales()
    {
        return $this->belongsToMany('App\Model\Sale', 'r_sale_product', 'productId', 'saleId')
        ->withPivot('id', 'qte', 'price');
    }
}
