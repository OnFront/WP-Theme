<?php

declare(strict_types=1);

namespace App\Controller;

defined('ABSPATH') || exit;

use App\Bundle\Framework\AbstractController;
use Timber\Post;
use Timber\PostQuery;
use Timber\Timber;

class HomeController extends AbstractController
{
    public function view(): string
    {
        $query = $this->WP()->query_vars;
        $post = new Post();
        $context = $this->context();

        $query['posts_per_page'] = 6;
        $posts = new PostQuery($query);
        $posts->pagination(['mid_size' => 1]);
        $terms = Timber::get_terms(['taxonomy' => 'category']);
        $settings = $post->meta('settings');

        $context['posts'] = $posts;
        $context['terms'] = $terms;
        $context['customTerm'] = [
            'link' => get_post_type_archive_link(get_post_type()),
            'name' => '',
        ];
        $context['currentCategorySlug'] = $query['category_name'] ?? '';
        $context['promoPost'] = new Post($settings['promoPost'] ?? 0);

        $context['post'] = $post;

        return $this->render('pages/home/home.twig', $context);
    }
}
