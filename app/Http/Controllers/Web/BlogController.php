<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->paginate(9);

        return view('pages.blog.index', compact('posts'));
    }

    public function show(BlogPost $blogPost): View
    {
        abort_unless($blogPost->is_published, 404);

        $related = BlogPost::published()
            ->where('id', '!=', $blogPost->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.blog.show', compact('blogPost', 'related'));
    }
}
