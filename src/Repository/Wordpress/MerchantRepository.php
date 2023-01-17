<?php

declare(strict_types=1);

namespace App\Repository\Wordpress;

defined("ABSPATH") || exit;

use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\Post\MerchantPost;
use Timber\PostQuery;
use Timber\Term;
use Timber\Timber;

final class MerchantRepository
{
    private string $postClass = MerchantPost::class;
    private const KEY_PROMOTION_IS_ENABLE = 'meta_promotion_is_enable';
    private const KEY_BIG_6_IS_ENABLE = 'meta_big_6_is_enable';

    /**
     * @return PostQuery|MerchantPost[]
     */
    public function findAll(): PostQuery
    {
        return new PostQuery(
            [
                'post_type' => MerchantsCustomPostType::NAME,
                'posts_per_page' => -1,
            ],
            $this->postClass,
        );
    }

    /**
     * @return Term[]
     */
    public function findAllTerms($hideEmpty = false): array
    {
        return Timber::get_terms(
            [
                'taxonomy' => MerchantsCustomPostType::TAXONOMY_NAME,
                'hide_empty' => $hideEmpty,
            ]
        );
    }

    /**
     * @return PostQuery|MerchantPost[]
     */
    public function findByTermIdsAndByIsPromo(array $ids, bool $isPromo): PostQuery
    {
        $query = [
            'post_type' => MerchantsCustomPostType::NAME,
            'posts_per_page' => -1,
        ];

        if ($ids) {
            $query['tax_query'] = [
                [
                    'taxonomy' => MerchantsCustomPostType::TAXONOMY_NAME,
                    'field' => 'term_id',
                    'terms' => $ids,
                ],
            ];
        }

        if ($isPromo) {
            $query['meta_query'] = [
                [
                    'key' => self::KEY_PROMOTION_IS_ENABLE,
                    'value' => '1',
                ],
            ];
        }

        return new PostQuery($query, $this->postClass);
    }

    /**
     * @return PostQuery|MerchantPost[]
     */
    public function findAllByPromo(bool $isPromo): PostQuery
    {
        $query = [
            'post_type' => MerchantsCustomPostType::NAME,
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => self::KEY_PROMOTION_IS_ENABLE,
                    'value' => $isPromo,
                ]
            ]
        ];

        return new PostQuery($query, $this->postClass);
    }

    /**
     * @return PostQuery|MerchantPost[]
     */
    public function findAllByPromoBig6(bool $isPromo): PostQuery
    {
        $query = [
            'post_type' => MerchantsCustomPostType::NAME,
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => self::KEY_BIG_6_IS_ENABLE,
                    'value' => $isPromo,
                ]
            ]
        ];

        return new PostQuery($query, $this->postClass);
    }
}
