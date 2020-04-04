<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Create;
use App\Http\Requests\Product\Update;
use App\Http\Resources\Product as ProductResource;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->middleware('admin', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return ProductResource::collection($this->product->index());
    }

    public function store(Create $request)
    {
        return new ProductResource($this->product->create($request->validated()));
    }

    public function show($id)
    {
        return new ProductResource($this->product->find($id));
    }

    public function update(Update $request, $id)
    {
        $result = $this->product->update($id, $request->validated());
        return $this->respondStatus($result);
    }

    public function destroy($id)
    {
        $result = $this->product->delete($id);
        return $this->respondStatus($result);
    }

    protected function respondStatus($result)
    {
        if ($result) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'Not found'], 404);
    }
}
