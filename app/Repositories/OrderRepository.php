<?php

namespace App\Repositories;

use App\Entities\Order;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create(array $data)
    {
        return auth()->user()->orders()->create($data)->load('user');
    }

    public function update($id, array $data)
    {
        return $this->order->find($id)->update($data);
    }
}
