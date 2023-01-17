<?php


namespace App\Controller;

defined('ABSPATH') || exit;

use App\Bundle\Framework\AbstractController;
use Timber\Post;

class PageController extends AbstractController
{
    public function view(): string
    {
        $post = new Post();

        $context = $this->context();
        $context['post'] = $post;

        return $this->render('page/index.twig', $context);
    }
}
