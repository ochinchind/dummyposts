<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\DeleteRequest;
use App\Http\Requests\Posts\EditRequest;
use App\Http\Requests\Posts\StoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Services\Posts\GetPosts\Service as GetPostsService;
use App\Services\Posts\CreatePost\Service as CreatePostService;
use App\Services\Posts\EditPost\Service as EditPostService;
use App\Services\Posts\DeletePost\Service as DeletePostService;
use App\Services\Posts\GeneratePostsData\Service as GeneratePostsDataService;

class PostsController extends Controller
{
    /**
     * Возвращает список постов
     *
     * @param  \Illuminate\Http\Request      $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $posts = (new GetPostsService)->execute($request->page ?? 1);
        $posts = (new GeneratePostsDataService)->execute($posts);

        return response()->json(['success' => true, 'message' => 'Данные успешно переданы!', 'data' => $posts], 200);
    }

    /**
     * Создает посты
     *
     * @param  \App\Http\Requests\Posts\StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $post = (new CreatePostService)->execute(
            Auth::id(),
            $request->dummy_post_id
        );

        return response()->json(['success' => true, 'message' => 'Пост успешно добавлен!', 'post' => $post], 200);
    }

    /**
     * Редактирует посты
     *
     * @param  int                                  $id
     * @param  \App\Http\Requests\Posts\EditRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, EditRequest $request): JsonResponse
    {
        try {
            $post = (new EditPostService)->execute(
                $id,
                Auth::id(),
                $request->dummy_post_id
            );

            return response()->json(['success' => true, 'message' => 'Пост успешно отредактирован!', 'post' => $post], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Удаляет посты
     *
     * @param  \App\Http\Requests\Posts\DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteRequest $request): JsonResponse
    {
        (new DeletePostService)->execute($request->id);

        return response()->json(['success' => true, 'message' => 'Пост успешно удален!'], 200);
    }
}
