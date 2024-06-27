<?php

namespace App\Services\Posts\GeneratePostsData;

use App\Models\Posts\Posts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class Service
{
    /**
     * Генерация данных постов для фронта
     *
     * @param  LengthAwarePaginator $posts
     * @return array
     */
    public function execute(LengthAwarePaginator $posts): array
    {
        $data = [];

        foreach ($posts as $post) {
            $response = $this->getPostFromDummyJson($post->dummy_post_id);
            $data[]   = [
                'id'       => $post->id,
                'title'    => $response['title'],
                'body'     => mb_substr($response['body'], 0, 128),
                'username' => $post->author->name
            ];
        }

        return $data;
    }

    /**
     * Возвращает данные из сайта dummyjson по айди
     *
     * @param  int   $id
     * @return array
     */
    private function getPostFromDummyJson(int $id): array
    {
        $response = Http::get("https://dummyjson.com/posts/{$id}");

        # if response succesfully then show response data
        if ($response->successful()){
            return $response->json();
        } else {
            return [
                'title' => '',
                'body'  => ''
            ];
        }
    }

}
