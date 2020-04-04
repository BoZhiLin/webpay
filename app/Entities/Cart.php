<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'cart_temp_id', 'product_id', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo('App\Entities\Product');
    }
}
