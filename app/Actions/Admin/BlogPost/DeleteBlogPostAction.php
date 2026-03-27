<?php

declare(strict_types=1);

namespace App\Actions\Admin\BlogPost;

use App\Models\BlogPost;

final class DeleteBlogPostAction
{
    public function execute(BlogPost $post): void
    {
        $post->delete();
    }
}
