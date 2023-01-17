<?php

declare(strict_types=1);

namespace App\Core;

use App\Bundle\RegisterHookInterface;

final class ThemeSupport implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_action('after_setup_theme', [$this, 'support']);
    }

    public function support(): void
    {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
    }
}
