<?php

namespace App\Services\Posts\GeneratePostsData;

use App\Http\Middleware\StoreVisitorIp;
use App\Models\Posts\Posts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class Service
{
    /**
     * Генерация данных постов для фронта
     *
     * @param  LengthAwarePaginator $posts
     * @return LengthAwarePaginator
     */
    public function execute(LengthAwarePaginator $posts): LengthAwarePaginator
    {
        foreach ($posts as $post) {
            $data        = $this->getPostFromDummyJson($post->dummy_post_id);
            $post->title = $data['title'];
            $post->body  = $data['body'];
        }

        return $posts;
    }

    /**
     * Возвращает данные из сайта dummyjson по айди
     *
     * @param  int  $id
     * @return void
     */
    private function getPostFromDummyJson(int $id): array
    {
        $response = Http::get("https://dummyjson.com/posts/{$id}");

        # if response succesfully then show response data
        if ($response->successful()){
            return $response->json();
        } else {
            return [
                'title' => null,
                'body'  => null
            ];
        }
    }

}
