<?php

namespace VeseluyRodjer\ServiceGenerator\Services;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function create(array $attributes): Model
    {
        return $this->repository->create($attributes);
    }

    public function findOrFail(int $id): Model
    {
        return $this->repository->findOrFail($id);
    }

    public function where(string $attr, string|int $val): Collection
    {
        return $this->repository->where($attr, $val);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->repository->update($id, $attributes);
    }

    public function destroy(int $id): bool
    {
        return $this->repository->destroy($id);
    }
}
