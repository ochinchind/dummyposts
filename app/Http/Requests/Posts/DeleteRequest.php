<?php

namespace App\Http\Requests\Posts;

use App\Models\Posts\Posts;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DeleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:posts,id', function($attribute, $value, $fail) {
                $post = Posts::find($value);
                if ($post && $post->user_id !== Auth::id()) {
                    $fail('Вы не являетесь владельцем поста!');
                }
            }]
        ];
    }

    /**
     * Обработка ошибки валидации
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->first(),
            ], 422)
        );
    }
}
