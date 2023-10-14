<?php

namespace App\Services\Repositories;

use App\Models\Article;
use App\Services\Interfaces\BlogInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BlogRepository implements BlogInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Article::all();
    }

    /**
     * @param int $id
     * @return Article|null
     */
    public function byId(int $id): ?Article
    {
        return Article::query()->find($id);
    }

    /**
     * @param Article $model
     * @return bool
     */
    public function store(Article $model): bool
    {
        return $model->save();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    // public function update(Request $request, int $id): bool
    public function update(array $data, int $id): bool
    {
        return Article::query()->find($id)->update($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Article::destroy($id);
    }
}
