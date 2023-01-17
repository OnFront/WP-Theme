<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Core\CustomPostType\MediaCustomPostType;
use App\Repository\Wordpress\MediaRepository;
use App\Service\CacheService;
use Timber\Post;
use Timber\Term;

class GlobalMediaAboutUsController extends AbstractController
{
    public function __construct(private MediaRepository $mediaRepository, private CacheService $cacheService)
    {
    }

    public function view(): string
    {
        $post = new Post();

        $context = $this->context();

        $cache = $this->cacheService->getItem('global-media-about-us');

        if (!$cache->isHit()) {
            $filter = $post->meta('filter');
            $selected = $filter['selected'];

            $selectedPostsId = [];

            foreach ($selected as $categories) {
                if ($categories) {
                    foreach ($categories as $category) {
                        $selectedPostsId[] = $category->ID;
                    }
                }
            }

            $context['mediaTerms'] = $this->mediaRepository->findAllTerms($this->onlyEngTerms());
            $context['post'] = $post;
            $context['mediaPosts'] = $this->mediaRepository->findAll(
                [
                    'post__not_in' => $selectedPostsId,
                    'post_status' => 'publish',
                    'tax_query' => [
                        [
                            'taxonomy' => MediaCustomPostType::TAXONOMY_NAME,
                            'field' => 'id',
                            'terms' => $this->findChildTerms($context['mediaTerms']),
                        ],
                    ],
                ]
            );
            $context['selectedPosts'] = $selected;
        }

        $context['cache'] = $cache;

        return $this->render('pages/global-media-about-us/global-media-about-us.twig', $context);
    }

    private function onlyEngTerms(): array
    {
        return [
            'meta_query' => [
                [
                    'key' => 'isENG',
                    'value' => true,
                    'compare' => '=',
                ],
            ],
        ];
    }


    /**
     * @param Term[] $terms
     */
    private function findChildTerms(array $terms): array
    {
        $excludeID = [
            'video' => 499,
            'presentations' => 500,
        ];

        $termsID = [];
        foreach ($terms as $term) {
            if (in_array($term->id, $excludeID, true) || $term->meta('parent')) {
                $termsID[] = $term->id;
            }
        }

        return $termsID;
    }
}
