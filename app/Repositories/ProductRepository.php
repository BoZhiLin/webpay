<?php

namespace App\Repositories;

use App\Entities\Product;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return $this->product->get();
    }

    public function find($id)
    {
        return $this->product->find($id);
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->product->find($id);
        return $product ? $product->update($data) : false;
    }

    public function delete($id)
    {
        return $this->product->destroy($id);
    }
}
