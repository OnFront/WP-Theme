<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Service\CookieService;
use App\Service\SwitchPayEye\SwitchPayEyeType;
use Timber\Post;

class BusinessZoneController extends AbstractController
{
    private Post $post;

    public function __construct(private CookieService $cookieService)
    {
        $this->post = new Post();

        if ($this->cookieService->getTypeAccount() === SwitchPayEyeType::CLIENT) {
            $this->cookieService->setCookieTypeAccount(SwitchPayEyeType::BUSINESS);
            wp_redirect($this->post->link());
            die();
        }

        $this->cookieService->setCookieTypeAccount(SwitchPayEyeType::BUSINESS);
    }


    public function view(): string
    {
        $context = $this->context();
        $context['post'] = $this->post;

        return $this->render('pages/business-zone/business-zone.twig', $context);
    }
}
