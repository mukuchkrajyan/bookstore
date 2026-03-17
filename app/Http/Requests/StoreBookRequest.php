<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'author' => ['required','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
        ];
    }
}