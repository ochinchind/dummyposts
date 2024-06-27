<?php

namespace App\Services\Posts\GetPosts;

use App\Models\Posts\Posts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Service
{
    /**
     * Сервис возвращающий посты
     *
     * @param  int                     $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function execute(int $page): LengthAwarePaginator
    {
        $posts = Posts::query()->paginate(10, ['*'], 'page', $page);

        return $posts;
    }

}
