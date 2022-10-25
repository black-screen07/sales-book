<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChargeCost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_chargeCost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'month',
        'amount',
        'chargeId',
        'userId',
    ];

    public function charge()
    {
        return $this->belongsTo('App\Model\Charge', 'chargeId', 'id');
    }
}
