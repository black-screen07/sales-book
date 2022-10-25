<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_sale';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dateS',
        'tt',
        'cash',
        'enabled',
        'userId',
        'customerId'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Model\Product', 'r_sale_product', 'saleId', 'productId')
        ->withPivot('id', 'qte', 'price');
    }


    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customerId', 'id');
    }
}
