<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplying extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_supplying';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deliverySheetCode',
        'dateS',
        'comment',
        'price',
        'userId',
        'supplierId'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Model\Product', 'r_supplying_product', 'supplyingId', 'productId')
        ->withPivot('id', 'qte');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Model\Supplier', 'supplierId', 'id');
    }
}
