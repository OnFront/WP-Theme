<?php

declare(strict_types=1);
        
namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use Timber\Post;

class CoursesController extends AbstractController
{
    public function view(): string
    {
        $post = new Post();

        $context = $this->context();

        $context['post'] = $post;
        $context['passwordForm'] = get_the_password_form($post->id);

        return $this->render('pages/courses/courses.twig', $context);
    }
}