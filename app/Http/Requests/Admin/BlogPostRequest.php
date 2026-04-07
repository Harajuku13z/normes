<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('blogPost')?->id ?? $this->route('blog_post')?->id ?? null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')->ignore($postId),
            ],
            'excerpt' => ['nullable', 'string', 'max:2000'],
            'content_html' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'string', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:2000'],
            'canonical_url' => ['nullable', 'string', 'max:2048'],
            'og_image' => ['nullable', 'string', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        foreach (['slug', 'excerpt', 'content_html', 'featured_image', 'meta_title', 'meta_description', 'canonical_url', 'og_image'] as $k) {
            if (array_key_exists($k, $data) && is_string($data[$k])) {
                $data[$k] = trim($data[$k]);
            }
        }
        return $data;
    }
}
