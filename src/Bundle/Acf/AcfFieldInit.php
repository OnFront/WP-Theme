<?php

declare(strict_types=1);

namespace App\Bundle\Acf;

use App\Bundle\RegisterHookInterface;

defined('ABSPATH') || exit;

final class AcfFieldInit implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_action('acf/include_field_types', [$this, 'init']);
    }

    public function init(): void
    {
        new UuidField();
    }
}
