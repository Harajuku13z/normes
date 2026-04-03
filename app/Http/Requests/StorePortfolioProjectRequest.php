<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePortfolioProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $raw = trim((string) $this->input('slug', ''));
        if ($raw === '') {
            $this->merge(['slug' => null]);

            return;
        }
        $normalized = Str::slug($raw);
        $this->merge(['slug' => $normalized !== '' ? $normalized : null]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolio_projects', 'slug')],
            'description' => ['nullable', 'string', 'max:65535'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'images' => ['nullable', 'array'],
            'images.*.path' => ['nullable', 'string', 'max:512'],
            'images.*.alt' => ['nullable', 'string', 'max:500'],
        ];
    }
}
