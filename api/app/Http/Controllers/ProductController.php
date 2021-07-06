<?php

namespace App\Http\Controllers;

use App\Contracts\ProductContract;
use App\Exceptions\ValidationException;
use App\Jobs\ProcessProductJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('products');
        if (!$request->hasFile('products') || !$file->isValid()) {
            return response('Arquivo ausente ou invalido', 400);
        }

        if ($file->extension() != 'json') {
            return response('O arquivo precisa ser um json', 400);
        }

        $path = $file->store('local');
        ProcessProductJson::dispatch($path);

        return response('Json enivado com sucesso', 200);
    }

    public function all(ProductContract $repository, Request $request)
    {
        return $repository->all($request->all());
    }

    public function show(ProductContract $repository, $id)
    {
        if (!intval($id)) {
            return response('Bad Request', 400);
        }
        $product = $repository->show($id);
        return response()->json($product, 200);
    }

    public function update(ProductContract $repository, Request $request, $id)
    {
        $productData = $request['product'];
        if (!intval($id) || !is_array($productData)) {
            return response('Bad Request', 400);
        }
        $product = $repository->update($productData, $id);
        return response()->json($product, 200);
    }

    public function delete(ProductContract $repository, $id)
    {
        if (!intval($id)) {
            return response('Bad Request', 400);
        }
        $deleted = $repository->delete($id);
        if ($deleted) {
            return response()->json('Deletado', 200);
        } else {
            return response()->json('Não foi possivel deletar ou o produto não existe', 409);
        }
    }
}
