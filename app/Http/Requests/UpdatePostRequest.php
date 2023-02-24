<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'nullable|string|max:150',
            'content'=>'nullable|string|max:1000',
            'images'=>'nullable',
            'tagged'=>'nullable|json',
            'images.*'=>['file','image','mimes:jpg,bmp,png'
                ,File::image()->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(500)
                )],
        ];
    }
}
