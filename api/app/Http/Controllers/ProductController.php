<?php

namespace App\Http\Controllers;

use App\Contracts\ProductContract;
use App\Jobs\ProcessProductJson;
use Illuminate\Http\Request;

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
        return $repository->all();
    }

    public function paginate(ProductContract $repository, Request $request)
    {
        return $repository->allPaginate($request->all());
    }

    public function show(ProductContract $repository, $id)
    {
        if (!intval($id)) {
            return $this->responseJson('O id é obrigatório', 400);
        }
        $product = $repository->show($id);
        return response()->json($product, 200);
    }

    public function update(ProductContract $repository, Request $request, $id)
    {
        $productData = $request['product'];
        if (!intval($id) || !is_array($productData)) {
            return $this->responseJson('O produto é obrigatório', 400);
        }
        $product = $repository->update($productData, $id);
        if (!$product) {
            return $this->responseJson('Não foi possivel atualizar o produto', 400);
        } else {
            return $this->responseJson('Produto atualizado com sucesso', 200);
        }
    }

    public function delete(ProductContract $repository, $id)
    {
        if (!intval($id)) {
            return $this->responseJson('O id é obrigatório', 400);
        }
        $deleted = $repository->delete($id);
        if ($deleted) {
            return $this->responseJson('Deletado', 200);
        } else {
            return $this->responseJson('Não foi possivel deletar ou o produto não existe', 409);
        }
    }

    private function responseJson($mens, $code)
    {
        return response()->json(['message' => $mens], $code);
    }
}
