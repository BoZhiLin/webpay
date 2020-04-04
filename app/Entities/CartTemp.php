<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartTemp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'serial_number', 'user_id', 'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function carts()
    {
        return $this->hasMany('App\Entities\Cart');
    }
}
