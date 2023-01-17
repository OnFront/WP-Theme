<?php

declare(strict_types=1);

namespace App\RestController;

defined('ABSPATH') || exit;

use App;
use App\Bundle\RegisterHookInterface;
use App\Core\CustomPostType\MerchantsCustomPostType;
use App\RestController\Controller\CreateOrderEyePOSController;
use App\RestController\Controller\DownloadMediaRestController;
use App\RestController\Controller\MerchantsRestController;
use App\RestController\Controller\QuestionRestController;
use WP_REST_Server;

class RegisterRestController implements RegisterHookInterface
{
    public const NAMESPACE = 'payeye/v1';

    public function registerHook(): void
    {
        add_action('rest_api_init', [$this, 'init']);

        add_filter('wp_rest_cache/allowed_endpoints', [$this, 'addCache'], 10, 1);
        add_filter('wp_rest_cache/determine_object_type', [$this, 'cacheObject'], 10, 4);
    }

    public function init(): void
    {
        $downloadMedia = App::getService(DownloadMediaRestController::class);
        $merchantsRest = App::getService(MerchantsRestController::class);
        $question = App::getService(QuestionRestController::class);
        $order = App::getService(CreateOrderEyePOSController::class);

        $this->registerRoute([$downloadMedia, 'getMedium'], '/download-media', WP_REST_Server::CREATABLE);

        $this->registerRoute([$merchantsRest, 'getMerchants'], '/merchants', WP_REST_Server::READABLE);
        $this->registerRoute([$merchantsRest, 'getMerchant'], '/merchants/(?P<id>\d+)', WP_REST_Server::READABLE);
        $this->registerRoute([$question, 'like'], '/question-like', WP_REST_Server::CREATABLE);
        $this->registerRoute([$order, 'create'], '/orders', WP_REST_Server::CREATABLE);
    }

    public function registerRoute(array $callback, string $route, string $methods): void
    {
        register_rest_route(
            self::NAMESPACE,
            $route,
            [
                'methods' => $methods,
                'callback' => $callback,
                'permission_callback' => [$this, 'permission'],
            ],
        );
    }

    public function permission(): bool
    {
        return true;
    }

    public function cacheObject($object_type, $cache_key, $data, $uri): string
    {
        if ($object_type !== 'unknown' || strpos($uri, self::NAMESPACE.'/'.'merchants') === false) {
            return $object_type;
        }

        return MerchantsCustomPostType::NAME;
    }

    public function addCache($allowed_endpoints): array
    {
        $namespace = self::NAMESPACE;
        $route = 'merchants';

        if (!isset($allowed_endpoints[$namespace]) || !in_array($route, $allowed_endpoints[$namespace], true)) {
            $allowed_endpoints[$namespace][] = $route;
        }

        return $allowed_endpoints;
    }

}
