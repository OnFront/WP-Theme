<?php

declare(strict_types=1);

namespace App\Repository\Wordpress;

defined("ABSPATH") || exit;

use App\Core\CustomPostType\FaqCustomPostType;
use Timber\PostQuery;
use Timber\Term;
use Timber\Timber;

class FaqRepository
{
    public function findByTerm(int $faqTermId): PostQuery
    {
        return new PostQuery(
            [
                'post_type' => FaqCustomPostType::NAME,
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => FaqCustomPostType::TAXONOMY_NAME,
                        'field' => 'term_id',
                        'terms' => [$faqTermId],
                    ],
                ],
            ]
        );
    }

    public function findAll(): PostQuery
    {
        return new PostQuery(
            [
                'post_type' => FaqCustomPostType::NAME,
                'posts_per_page' => -1,
            ]
        );
    }

    /**
     * @return Term[]
     */
    public function findAllTerms($hideEmpty = false): array
    {
        return Timber::get_terms(
            [
                'taxonomy' => FaqCustomPostType::TAXONOMY_NAME,
                'hide_empty' => $hideEmpty,
            ]
        );
    }
}
