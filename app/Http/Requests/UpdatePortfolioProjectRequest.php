<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:65535'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'images' => ['nullable', 'array'],
            'images.*.path' => ['nullable', 'string', 'max:512'],
            'images.*.alt' => ['nullable', 'string', 'max:500'],
        ];
    }
}
