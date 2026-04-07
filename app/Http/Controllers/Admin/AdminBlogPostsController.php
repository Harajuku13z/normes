<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminBlogPostsController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.blog_posts.index', compact('posts'));
    }

    public function create(): View
    {
        $post = new BlogPost();

        return view('admin.blog_posts.edit', compact('post'));
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $post = BlogPost::query()->create($data);

        return redirect()
            ->route('admin.blog_posts.edit', $post)
            ->with('status', 'Article créé.');
    }

    public function edit(BlogPost $blogPost): View
    {
        $post = $blogPost;

        return view('admin.blog_posts.edit', compact('post'));
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $blogPost->update($data);

        return back()->with('status', 'Article mis à jour.');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        return redirect()->route('admin.blog_posts.index')->with('status', 'Article supprimé.');
    }
}
