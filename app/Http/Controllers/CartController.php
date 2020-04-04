<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\Create;
use App\Http\Resources\CartTemp as CartTempResource;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth:api');
    }

    /**
     * 取得當前購物車
     */
    public function index()
    {
        $data = auth()->user()->cartTemps()->with('carts.product')->first();
        return new CartTempResource($data);
    }

    /**
     * 新增商品至購物車
     */
    public function store(Create $request)
    {
        $currentCart = $this->cartService->createDetail($request->validated());
        return new CartTempResource($currentCart);
    }
}
