<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Service\CookieService;
use App\Service\SwitchPayEye\SwitchPayEyeType;
use Timber\Post;

class CustomerZoneController extends AbstractController
{
    private Post $post;

    public function __construct(private CookieService $cookieService)
    {
        $this->post = new Post();

        if ($this->cookieService->getTypeAccount() === SwitchPayEyeType::BUSINESS) {
            $this->cookieService->setCookieTypeAccount(SwitchPayEyeType::CLIENT);
            wp_redirect($this->post->link());
            die();
        }

        $this->cookieService->setCookieTypeAccount(SwitchPayEyeType::CLIENT);
    }

    public function view(): string
    {
        $context = $this->context();
        $context['post'] = $this->post;

        return $this->render('pages/customer-zone/customer-zone.twig', $context);
    }
}
