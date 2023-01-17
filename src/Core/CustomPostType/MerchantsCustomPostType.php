<?php

declare(strict_types=1);

namespace App\Core\CustomPostType;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;

final class MerchantsCustomPostType implements RegisterHookInterface
{
    public const NAME = 'merchants';
    public const TAXONOMY_NAME = 'category-merchants';

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
            'label' => 'Merchanci',
            'rewrite' => [
                'slug' => 'wpis-merchant',
                'with_front' => false,
            ],
            'has_archive' => false,
            'menu_icon' => 'dashicons-networking',
            'supports' => ['title'],
        ];
    }

    protected function argsTaxonomy(): array
    {
        return [
            'labels' => [
                'name' => 'Kategoria merchanci',
            ],
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
        ];
    }
}
