<?php

declare(strict_types=1);

namespace App\Service;

use App\Core\CustomPostType\LogCustomPostType;

defined('ABSPATH') || exit;

class LogService
{
    public function add(string $title, string $content): void
    {
        wp_insert_post(
            [
                'post_type' => LogCustomPostType::NAME,
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'publish',
            ]
        );
    }
}
