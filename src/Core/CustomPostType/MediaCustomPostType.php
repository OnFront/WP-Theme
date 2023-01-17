<?php

declare(strict_types=1);

namespace App\Core\CustomPostType;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;

final class MediaCustomPostType implements RegisterHookInterface
{
    public const NAME = 'media-about-us';
    public const TAXONOMY_NAME = 'category-media-about-us';

    public function registerHook(): void
    {
        add_action(
            'init',
            function () {
                register_post_type(self::NAME, $this->argsCustomPostType());
                register_taxonomy(self::TAXONOMY_NAME, self::NAME, $this->argsTaxonomy());
            },
        );
    }

    protected function argsCustomPostType(): array
    {
        return [
            'public' => true,
            'label' => 'Media o nas',
            'rewrite' => [
                'slug' => 'media-o-nas',
                'with_front' => false,
            ],
            'has_archive' => false,
            'menu_icon' => 'dashicons-spotify',
            'supports' => ['title'],
        ];
    }

    protected function argsTaxonomy(): array
    {
        return [
            'labels' => [
                'name' => 'Kategoria Media o nas',
            ],
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
        ];
    }
}
