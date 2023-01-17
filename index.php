<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

use App\Bundle\Timber\TimberTermLink;
use App\Controller\FrontPageController;
use App\Controller\HomeController;
use App\Controller\Page404Controller;
use App\Controller\PageController;
use App\Controller\PostController;
use App\Controller\SearchResultsController;
use Timber\Term;

if (get_queried_object() instanceof WP_Term) {
    redirectToCustomQueryLinkFormCategoryPage(get_queried_object_id());
}

if (is_front_page()) {
    loadController(FrontPageController::class);
}

if (is_page()) {
    loadController(PageController::class);
}

if (is_singular('post')) {
    loadController(PostController::class);
}

if (is_search()) {
    loadController(SearchResultsController::class);
}

if (is_home()) {
    loadController(HomeController::class);
}

if (is_404()) {
    loadController(Page404Controller::class);
}

function loadController(string $controller): void
{
    $controller = App::getService($controller);
    echo $controller->view();
    die();
}

function redirectToCustomQueryLinkFormCategoryPage(int $termId)
{
    $term = new Term($termId);
    $link = TimberTermLink::generateQueryLink($term);

    wp_safe_redirect($link);
    die();
}
