<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\BlogPost\CreateBlogPostAction;
use App\Actions\Admin\BlogPost\DeleteBlogPostAction;
use App\Actions\Admin\BlogPost\UpdateBlogPostAction;
use App\DTOs\Admin\BlogPostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogPostRequest;
use App\Http\Requests\Admin\UpdateBlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::latest()->paginate(20);

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog-posts.create');
    }

    public function store(StoreBlogPostRequest $request, CreateBlogPostAction $action): RedirectResponse
    {
        $action->execute(BlogPostDTO::fromRequest($request));

        return redirect()->route('admin.blog-posts.index')
            ->with('success', __t('admin.blog_post_created'));
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost, UpdateBlogPostAction $action): RedirectResponse
    {
        $action->execute($blogPost, BlogPostDTO::fromRequest($request));

        return redirect()->route('admin.blog-posts.index')
            ->with('success', __t('admin.blog_post_updated'));
    }

    public function destroy(BlogPost $blogPost, DeleteBlogPostAction $action): RedirectResponse
    {
        $action->execute($blogPost);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', __t('admin.blog_post_deleted'));
    }
}
