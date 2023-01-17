<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\Post\MerchantPost;
use App\Repository\Wordpress\MerchantRepository;
use Timber\Post;
use Timber\Term;

class PromotionApplicationController extends AbstractController
{
    public function __construct(private MerchantRepository $merchantRepository)
    {
    }

    public function view(): string
    {
        $posts = $this->merchantRepository->findAllByPromo(true)->get_posts();

        $context = $this->context();
        $context['post'] = new Post();
        $context['posts'] = $posts;
        $context['categories'] = $this->categoriesWithPromo($posts);

        return $this->render('pages/promotion-application/promotion-application.twig', $context);
    }

    /**
     * @param MerchantPost[]
     * @return Term[]
     */
    private function categoriesWithPromo($partnerPosts): array
    {
        $categoriesWithPromo = [];
        foreach ($partnerPosts as $post) {
            if ($post->category()) {
                $categoriesWithPromo[] = $post->category();
            }
        }

        return array_unique($categoriesWithPromo);
    }
}
