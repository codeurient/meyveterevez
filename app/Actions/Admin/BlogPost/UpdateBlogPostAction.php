<?php

declare(strict_types=1);

namespace App\Actions\Admin\BlogPost;

use App\DTOs\Admin\BlogPostDTO;
use App\Models\BlogPost;

final class UpdateBlogPostAction
{
    public function execute(BlogPost $post, BlogPostDTO $dto): BlogPost
    {
        $post->update([
            'title'                => $dto->title,
            'title_translations'   => $dto->titleTranslations,
            'slug'                 => $dto->slug,
            'excerpt'              => $dto->excerpt,
            'excerpt_translations' => $dto->excerptTranslations,
            'content'              => $dto->content,
            'content_translations' => $dto->contentTranslations,
            'read_time'            => $dto->readTime,
            'is_published'         => $dto->isPublished,
            'published_at'         => $dto->publishedAt,
        ]);

        return $post->fresh();
    }
}
