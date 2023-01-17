<?php

declare(strict_types=1);

namespace App\Controller;

defined('ABSPATH') || exit;

use App;
use App\Bundle\Framework\AbstractController;
use Timber\Post;

class FrontPageController extends AbstractController
{
    public function view(): string
    {
        $context = $this->context();
        $context['post'] = new Post();

        return $this->render('pages/front/front.twig', $context);
    }
}
