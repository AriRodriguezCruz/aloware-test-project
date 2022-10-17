<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'postId'    => 'sometimes|exists:posts,id|integer',
            'parentId'  => 'sometimes|exists:comments,id|integer',
            'name'      => 'required|string|min:3|max:255',
            'message'   => 'required|string|min:3',
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],500));
    }

    /**
     * @param $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['postId'] = $this->route('postId');
        $data['parentId'] = $this->route('parentId');
        return $data;
    }
}
