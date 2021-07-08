<?php

namespace App\Repositories;

use App\Contracts\ProductContract;
use App\Models\Product;

class ProductRepository extends AbstractRepository implements ProductContract
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    public function save($data)
    {
        $this->validator($data, $this->model->rules());
        $product = $this->model->create($data);
        if (!$product) {
            return false;
        }
        return $product->toArray();
    }

    public function update($data, $id)
    {
        $this->validator($data, $this->model->rules());
        $product = $this->model->findOrFail($id);
        return $product->fill($data)->save();
    }

    public function all($request)
    {
        return $this->model->all();
    }

    public function delete(int $id)
    {
        $product = $this->model->find($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }

    public function show(int $id)
    {
        $product = $this->model->findOrFail($id);
        return $product->toArray();
    }
}
