<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Core\CustomPostType\FaqCustomPostType;
use App\Repository\Wordpress\FaqRepository;
use Timber\Post;
use Timber\PostQuery;

class SecurityController extends AbstractController
{
    public function __construct(private FaqRepository $faqRepository)
    {
    }


    public function view(): string
    {
        $post = new Post();

        $context = $this->context();
        $context['post'] = $post;
        $context['faqPosts'] = $this->faqRepository->findByTerm($post->meta('faq')['faqTermId']);

        return $this->render('pages/security/security.twig', $context);
    }
}
