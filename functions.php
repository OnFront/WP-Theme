<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

use App\Bundle\Wordpress\CustomTemplate;
use App\InitHooks;
use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->overload(__DIR__.'/.env');

require_once 'App.php';
require_once 'config/twig.php';
require_once 'config/container.php';

InitHooks::registerHooks();

new CustomTemplate(require __DIR__.'/config/controllers.php');

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        [
            'page_title' => 'PayEye',
            'menu_title' => 'PayEye',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
        ]
    );
}


add_filter('bea.aofp.get_default', '__return_false');

add_action(
    'pre_get_posts',
    static function (WP_Query $query) {
        if ($query->is_main_query() && !is_admin()) {
            $query->set('post_type', array('page', 'post'));
        }
    }
);

add_filter(
    'rest_endpoints',
    function ($endpoints) {
        if (isset($endpoints['/wp/v2/users'])) {
            unset($endpoints['/wp/v2/users']);
        }
        if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
            unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        }

        if (isset($endpoints['/wp/v2/pages'])) {
            unset($endpoints['/wp/v2/pages']);
        }

        return $endpoints;
    },
);

add_action('after_delete_post', function (int $postId) {
    global $wpdb;

    $wpdb->delete($wpdb->postmeta, ['post_id' => $postId]);
});
