<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_userLevel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'code';


    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
