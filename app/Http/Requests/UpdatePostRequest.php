<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|min:2',
            'content' => 'required|min:10',
            'image' => [
                File::image()
                    ->types(['jpeg', 'jpg', 'jpe'])
                    ->min(1024)
                    ->max(3 * 1024)
            ]
        ];
    }
}
