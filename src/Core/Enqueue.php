<?php

declare(strict_types=1);

namespace App\Core;

defined('ABSPATH') || exit;

use App;
use App\Bundle\Helper\HelperController;
use App\Bundle\RegisterHookInterface;
use App\Controller\ContactController;
use App\Controller\MapPointsController;
use App\Controller\PromotionApplicationController;
use App\Controller\PromotionBigSixApplicationController;
use App\Controller\PromotionBigSixController;
use App\Controller\PromotionController;
use App\Controller\QuestionsController;

class Enqueue implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueFront'], 99999);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin'], 99999);
    }

    public function enqueueFront(): void
    {
        wp_deregister_style('contact-form-7');

        if (!$this->isControllerWithForm()) {
            wp_deregister_script('contact-form-7');
            wp_deregister_script('wpcf7cf-scripts');
            wp_deregister_script('google-recaptcha');
            wp_deregister_script('wpcf7-recaptcha');

            wp_deregister_style('cf7cf-style');
        }

        if (App::isDevelop()) {
            wp_enqueue_style('app-style', App::uri().'/public/css/index.css', '', App::getVersion());
        }

        if (is_front_page()) {
            wp_enqueue_script('front-script', App::uri().'/public/js/front.js', '', App::getVersion());
        }

        wp_enqueue_script('app-script', App::uri().'/public/js/index.js', '', App::getVersion(), true);

        if (HelperController::getTemplateFile(MapPointsController::class) === get_page_template_slug()) {
            wp_enqueue_script('app-list-partners', App::uri().'/public/js/list-partners.js', '', App::getVersion(), true);
        }

        if (!is_home() && in_array(
                get_page_template_slug(),
                [
                    HelperController::getTemplateFile(PromotionController::class),
                    HelperController::getTemplateFile(PromotionApplicationController::class),
                    HelperController::getTemplateFile(PromotionBigSixController::class),
                    HelperController::getTemplateFile(PromotionBigSixApplicationController::class),
                ],
                true
            )) {
            wp_enqueue_script('app-promo', App::uri().'/public/js/promo.js', '', App::getVersion(), true);
        }
    }

    public function enqueueAdmin(): void
    {
        wp_enqueue_script('app-script', App::uri().'/public/js/admin.js', '', App::getVersion(), true);
    }

    private function isControllerWithForm(): bool
    {
        $isForm = false;
        $currentSlug = get_page_template_slug();

        $formController = [
            ContactController::class,
            QuestionsController::class,
        ];

        foreach ($formController as $item) {
            $isForm = $isForm || HelperController::getTemplateFile($item) === $currentSlug;
        }

        return $isForm;
    }
}
