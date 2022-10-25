<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'phone',
        'adress',
        'enabled',
        'userLevelCode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get image.
     */
    public function getImg()
    {
        if ($this->img && file_exists(public_path('storage/'.config('global.image_user').'/'.$this->img))) {
            $img = asset('storage/'.config('global.image_user').'/'.$this->img);
        } else {
            $img = asset(config('global.default_image_user'));
        }

        return $img;
    }

    public function level()
    {
        return $this->belongsTo('App\Model\UserLevel', 'userLevelCode', 'code');
    }

    public function isAdmin()
    {
        if($this->userLevelCode==config('global.levelAdmin')) return true;
        else return false;
    }
}
