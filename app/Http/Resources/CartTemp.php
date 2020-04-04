<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartTemp extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cart_temp_id' => $this->id,
            'expired_at' => $this->expired_at,
            'carts' => Cart::collection($this->carts)
        ];
    }
}
