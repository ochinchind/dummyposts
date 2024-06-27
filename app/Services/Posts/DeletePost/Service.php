<?php

namespace App\Services\Posts\DeletePost;

use App\Models\Posts\Posts;

class Service
{
    /**
     * Сервис редактирования постов
     *
     * @param  int  $id
     * @return void
     */
    public function execute(int $id): void
    {
        Posts::where('id', $id)->delete();
    }
}
