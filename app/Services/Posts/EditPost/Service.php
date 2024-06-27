<?php

namespace App\Services\Posts\EditPost;

use App\Models\Posts\Posts;
use Exception;

class Service
{
    /**
     * Сервис редактирования постов
     *
     * @param  int        $id
     * @param  int        $user_id
     * @param  int        $dummyPostId
     * @return Posts
     * @throws Exception
     */
    public function execute(int $id, int $user_id, int $dummyPostId): Posts
    {
        $post = Posts::where('id', $id)->firstOrFail();

        if ($post->user_id !== $user_id) {
            throw new Exception('Вы не являетесь владельцем поста!', 403);
        }

        $post->update([
            'dummy_post_id' => $dummyPostId
        ]);

        return $post;
    }
}
