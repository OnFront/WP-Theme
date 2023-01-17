<?php

declare(strict_types=1);

namespace App\Core;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;

final class NavMenus implements RegisterHookInterface
{
    public const MENU_CLIENT = 'primaryMenu';
    public const MENU_PARTNER = 'primaryMenuPartner';

    public function registerHook(): void
    {
        add_action('after_setup_theme', [$this, 'register'], 0);
    }

    public function register(): void
    {
        register_nav_menus($this->menus());
    }

    public function menus(): array
    {
        return [
            self::MENU_CLIENT => 'Klient',
            'footerMenuOne' => 'Stopka pierwsza',
            'footerMenuTwo' => 'Stopka druga',
            'footerMenuThree' => 'Stopka trzecia',
            'footerMenuFour' => 'Stopka czwarta',
            self::MENU_PARTNER => 'Partner',
        ];
    }
}
