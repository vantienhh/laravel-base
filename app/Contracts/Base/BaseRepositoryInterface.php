<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function getModel(): Model|Builder;

    public function getById(mixed $id): Model|Collection|static;

    public function getByIdInTrash(mixed $id): Model|Collection|static;

    public function getByQuery(array $params = [], int $size = 20);

    public function store(array $params): Model|static;

    public function storeArray(array $listData): bool;

    public function update(mixed $id, array $data, array $excepts = [], array $only = []): Model|Collection|static;

    public function delete($id): bool|null;

    public function destroy($id): bool|null;

    public function restore(mixed$id): bool|null;

}
