<?php

namespace App\Services\Interfaces;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface BlogInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection;

    /**
     * @param int $id
     * @return Article|null
     */
    public function byId(int $id): ?Article;

    /**
     * @param Article $model
     * @return bool
     */
    public function store(Article $model): bool;

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
