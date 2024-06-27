<?php

namespace App\Services\Posts\CreatePost;

use App\Models\Posts\Posts;

class Service
{
    /**
     * Сервис создания постов
     *
     * @param  int                     $userId
     * @param  int                     $dummyPostId
     * @return \App\Models\Posts\Posts
     */
    public function execute(int $userId, int $dummyPostId): Posts
    {
        $post = Posts::create([
            'user_id'       => $userId,
            'dummy_post_id' => $dummyPostId
        ]);

        return $post;
    }

}
