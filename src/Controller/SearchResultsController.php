<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use Timber\PostQuery;

class SearchResultsController extends AbstractController
{
    public function view(): string
    {
        $query = $this->WP()->query_vars;
        $query['posts_per_page'] = 6;
        $query['post_type'] = 'post';

        $context = $this->context();
        $context['posts'] = new PostQuery($query);
        $context['searchQuery'] = $query['s'] ?? '';

        return $this->render('pages/search-results/search-results.twig', $context);
    }
}
