<?php

namespace App\Contracts;

interface ProductContract
{
    public function save(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function show(int $id);

    public function all(array $request);
}
