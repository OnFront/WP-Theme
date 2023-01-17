<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Service\CacheService;
use Timber\Post;

class TeamController extends AbstractController
{
    public function __construct(private CacheService $cacheService)
    {
    }

    public function view(): string
    {
        $cache = $this->cacheService->getItem('team-page');

        $context = $this->context();
        $context['post'] = new Post();
        $context['cache'] = $cache;

        return $this->render('pages/team/team.twig', $context);
    }
}
