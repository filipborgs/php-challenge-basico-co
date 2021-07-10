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

    public function all()
    {
        return $this->model->all();
    }

    public function allPaginate($request)
    {
        $search = array_key_exists('search', $request) ? $request['search'] : null;
        return $this->model->select(
            'id',
            'title',
            'type',
            'price',
            'rating',
            'created_at'
        )
            ->where('title', 'LIKE', "%$search%")->paginate(10);
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
