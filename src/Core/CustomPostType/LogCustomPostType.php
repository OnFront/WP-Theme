<?php

declare(strict_types=1);

namespace App\Core\CustomPostType;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;
use JsonException;
use WP_Post;

final class LogCustomPostType implements RegisterHookInterface
{
    public const NAME = 'payeye-log';

    public function registerHook(): void
    {
        add_action('init', [$this, 'init']);
        add_action('edit_form_after_title', [$this, 'content']);
    }

    public function init(): void
    {
        register_post_type(self::NAME, $this->argsCustomPostType());
    }

    public function argsCustomPostType(): array
    {
        return [
            'public' => false,
            'label' => 'Logger',
            'menu_icon' => 'dashicons-code-standards',
            'rewrite' => [
                'with_front' => false,
            ],
            'supports' => ['title'],
            'exclude_from_search' => true,
            'publicaly_queryable' => false,
            'query_var' => false,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'menu_position' => 3,

            'capabilities' => [
                'create_posts' => false,
            ],
            'map_meta_cap' => true,
        ];
    }

    public function content(WP_Post $post): void
    {
        if ($post->post_type === self::NAME) {
            try {
                $content = json_decode($post->post_content, true, 512, JSON_THROW_ON_ERROR);
                print('<pre>' . print_r($content, true) . '</pre>');
            } catch (JsonException $e) {
            }
        }
    }
}
