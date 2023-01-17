<?php

declare(strict_types=1);

namespace App\Bundle\Orphans;

use App\Bundle\RegisterHookInterface;
use iworks_orphan;

defined('ABSPATH') || exit;

final class Orphans implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter('acf/format_value/type=textarea', [$this, 'orphans'], 10, 3);
        add_filter('acf/format_value/type=wysiwyg', [$this, 'orphans'], 10, 3);
        add_filter('acf/format_value/type=text', [$this, 'orphans'], 10, 3);
    }

    public function orphans($value, $post_id, $field)
    {
        if (class_exists('iworks_orphan')) {
            static $orphan;

            if (!$orphan) {
                $orphan = new iworks_orphan();
            }

            $value = $orphan->replace($value);
        }
        return $value;
    }
}
