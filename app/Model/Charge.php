<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_charge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
