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

class MediaController extends AbstractController
{
    public function __construct(private MediaRepository $mediaRepository, private CacheService $cacheService)
    {
    }

    public function view(): string
    {
        $post = new Post();
        $context = $this->context();

        $cache = $this->cacheService->getItem('media-about-us');

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

            $context['post'] = $post;
            $context['mediaPosts'] = $this->mediaRepository->findAll(
                [
                    'post__not_in' => $selectedPostsId,
                    'post_status' => 'publish',
                    'tax_query' => [
                        [
                            'taxonomy' => MediaCustomPostType::TAXONOMY_NAME,
                            'field' => 'id',
                            'terms' => array_map(static fn(Term $term) => $term->id, $filter['taxonomies']),
                        ],
                    ],
                ]
            );
            $context['mediaTerms'] = $this->mediaRepository->findAllTerms();
            $context['selectedPosts'] = $selected;
        }

        $context['cache'] = $cache;

        return $this->render('pages/media/media.twig', $context);
    }
}
