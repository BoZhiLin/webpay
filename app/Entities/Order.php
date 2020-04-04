<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'cart_temp_id', 'price', 'is_pay',
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function cartTemp()
    {
        return $this->belongsTo('App\Entities\CartTemp', 'cart_temp_id');
    }
}
