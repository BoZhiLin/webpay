<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'price',
    ];

    public function category()
    {
        return $this->belongsTo('App\Entities\Category');
    }
}
