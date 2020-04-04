<?php

namespace App\Services;

class CartService
{
    /**
     * 將待買商品新增至購物車
     * 
     * @param array $data
     * @return \App\Entities\Cart $cart
     */
    public function createDetail(array $data)
    {
        $cart = $this->getCartExists($data['cart_temp_id']);
        $cart->carts()->create($data);
        return $cart;
    }

    /**
     * 回傳當前可用購物車 (存在且未過期)
     * 
     * @param int $id
     * @return model
     */
    private function getCartExists($id)
    {
        $cart = auth()->user()->cartTemps()->find($id);

        if (!$cart) {
            return auth()->user()->cartTemps()->first() ?? $this->createNewCart();
        } else {
            if ($cart->expired_at < now()) {
                $cart->delete();

                return $this->createNewCart();
            }
    
            return $cart;
        }  
    }

    private function createNewCart()
    {
        $serialNumber = random_int(100, 999).auth()->id();

        return auth()->user()
            ->cartTemps()
            ->create([
                'serial_number' => $serialNumber,
                'expired_at' => now()->addHour()
            ]); 
    }
}
