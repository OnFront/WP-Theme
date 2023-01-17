<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Repository\Wordpress\QuestionRepository;
use App\Service\CookieService;
use Timber\Post;

class QuestionsController extends AbstractController
{
    private Post $post;
    private QuestionRepository $questionRepository;
    private CookieService $cookieService;

    public function __construct(Post $post, QuestionRepository $questionRepository, CookieService $cookieService)
    {
        $this->post = $post;
        $this->questionRepository = $questionRepository;
        $this->cookieService = $cookieService;
    }

    public function view(): string
    {
        $post = $this->post;

        $context = $this->context();
        $context['post'] = $post;
        $context['questions'] = $this->questionRepository->findAll();
        $context['cookies'] = $this->cookieService->getQuestions();

        return $this->render('questions/index.twig', $context);
    }
}
