<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\OrderRepository;
use App\Packages\NewebpayPackage;

class OrderService
{
    protected $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function pay(array $data)
    {
        $price = $this->calculateTotalPrice(auth()->user()->cartTemps()->find($data['cart_temp_id'])->carts);
        $data['price'] = $price;
        $order = $this->order->create($data);
        $mpgInfo = clone $order;
        $products = $this->handleProducts($order->cartTemp->carts);
        $mpgInfo->products = $products;
        return NewebpayPackage::mpg($mpgInfo->toArray());
    }

    public function adjustPayStatus($tradeInfo)
    {
        $notifyInfo = NewebpayPackage::create_aes_decrypt($tradeInfo);
        $notifyInfo = json_decode($notifyInfo);
        return $this->order->update($notifyInfo->Result->MerchantOrderNo, ['is_pay' => 1]);
    }

    /**
     * 計算購物車內商品總金額
     * 
     * @param Collection $carts
     * @return int $price
     */
    private function calculateTotalPrice(Collection $carts)
    {
        return $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });
    }

    /**
     * 處理購物車內商品名稱 (FOR 藍新金流)
     */
    private function handleProducts(Collection $carts)
    {
        $products = $carts->map(function ($cart) {
            return $cart->product->name;
        })->toArray();

        return implode(',', $products);
    }
}
