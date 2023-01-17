<?php

declare(strict_types=1);

namespace App\Repository\Wordpress;

defined("ABSPATH") || exit;

use App\Core\CustomPostType\MediaCustomPostType;
use Timber\PostQuery;
use Timber\Term;
use Timber\Timber;

final class MediaRepository
{
    public function findAll(array $args = []): PostQuery
    {
        $query = [
            'post_type' => MediaCustomPostType::NAME,
            'posts_per_page' => -1,
        ];

        $query = array_merge($query, $args);

        return new PostQuery($query);
    }

    /**
     * @return Term[]
     */
    public function findAllTerms(array $args = []): array
    {
        $query = [
            'taxonomy' => MediaCustomPostType::TAXONOMY_NAME,
        ];

        $query = array_merge($query, $args);

        return Timber::get_terms($query);
    }
}
