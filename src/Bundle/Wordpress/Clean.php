<?php

namespace App\Bundle\Wordpress;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;

class Clean implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter('script_loader_src', [$this, 'remove_wp_version_strings']);
        add_filter('style_loader_src', [$this, 'remove_wp_version_strings']);

        add_filter('the_generator', [$this, 'remove_meta_version']);

        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }

        add_filter('emoji_svg_url', '__return_false');
        add_action(
            'wp_footer',
            function () {
                wp_dequeue_script('wp-embed');
            }
        );
        add_action(
            'wp_print_styles',
            function () {
                wp_dequeue_style('wp-block-library');
            }
        );
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'rel_canonical');

        add_filter('wpcf7_autop_or_not', '__return_false');


        add_filter('use_block_editor_for_post', '__return_false', 10);
        add_filter('use_block_editor_for_post_type', '__return_false', 10);


        add_action('wp_enqueue_scripts', [$this, 'remove_block_scripts'], 9999);
    }

    public function remove_wp_version_strings($src)
    {
        global $wp_version;

        parse_str(wp_parse_url($src, PHP_URL_QUERY), $query);
        if (!empty($query['ver']) && $query['ver'] === $wp_version) {
            $src = remove_query_arg('ver', $src);
        }

        return $src;
    }

    public function remove_meta_version(): string
    {
        return '';
    }

    public function remove_block_scripts(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_style('storefront-gutenberg-blocks');
        wp_dequeue_style('global-styles');
    }
}
