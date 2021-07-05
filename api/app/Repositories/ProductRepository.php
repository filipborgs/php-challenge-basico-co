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
        $product = $this->model->fill($data);
        $product->save();
        return $product->array();
    }

    public function update($data, $id)
    {
        $this->validator($data, $this->model->rules());
    }

    public function all($request)
    {
        return $this->model->paginate();
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function show(int $id)
    {
        return $this->model->find($id);
    }
}
