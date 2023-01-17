<?php

declare(strict_types=1);

namespace App\Bundle\ClearCache;

use App;
use App\Bundle\RegisterHookInterface;
use Routes;
use WP_Admin_Bar;
use WP_Rest_Cache_Plugin\Includes\Caching\Caching;

defined('ABSPATH') || exit;

class ClearCache implements RegisterHookInterface
{
    private const CACHE_NONCE = 'payeye-clear-cache';

    public function registerHook(): void
    {
        add_action('admin_bar_menu', [$this, 'menuClearCache'], 100);
        add_action('save_post', [$this, 'savePost']);
        Routes::map('payeye-clear-cache', [$this, 'clearCache']);
    }

    public function menuClearCache(WP_Admin_Bar $admin_bar): void
    {
        $nonce = wp_create_nonce('payeye-clear-cache');

        $admin_bar->add_menu(
            [
                'id' => self::CACHE_NONCE,
                'title' => 'Clear cache',
                'href' => site_url() . '/payeye-clear-cache?nonce=' . $nonce,
            ],
        );
    }

    public function clearCache(): void
    {
        $nonce = $_GET['nonce'] ?? '';

        if (is_user_logged_in() && wp_verify_nonce($nonce, self::CACHE_NONCE)) {
            App::getCacheService()->getFilesystemAdapter()->clear();

            $back = '<a href="' . $_SERVER["HTTP_REFERER"] . '">Powrót</a>';

            wp_die('Wszystkie pliki statyczne zostały wyczyszczone. Wróc do strony: ' . $back);
        }
    }

    public function savePost($postId): void
    {
        App::getCacheService()->getFilesystemAdapter()->clear();
        if (class_exists(Caching::class)) {
            Caching::get_instance()?->delete_all_caches(true);
        }
    }
}
