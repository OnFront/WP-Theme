<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use Timber\Post;

class ContactController extends AbstractController
{
    public function view(): string
    {
        $context = $this->context();
        $context['post'] = new Post();

        return $this->render('pages/contact/contact.twig', $context);
    }
}
