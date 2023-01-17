<?php

declare(strict_types=1);

namespace App\Bundle\Helper;

defined('ABSPATH') || exit;

abstract class HelperSvg
{
    public static function svg(?string $svg, string $class = '', string $dataAttr = ''): string
    {
        $username = $_ENV['UAT_BASE_AUTH_USERNAME'];
        $password = $_ENV['UAT_BASE_AUTH_PASSWORD'];

        if ($svg && isset($_SERVER['REQUEST_SCHEME'])) {
            $context = stream_context_create(
                array(
                    $_SERVER['REQUEST_SCHEME'] => array(
                        'header' => "Authorization: Basic ".base64_encode("$username:$password"),
                    ),
                )
            );

            $content = file_get_contents($svg, false, $context);

            return str_replace('<svg', '<svg '.$dataAttr.' class="'.$class.'"', $content);
        }

        $content = file_get_contents($svg, false);

        if ($svg && $content) {
            return str_replace('<svg', '<svg '.$dataAttr.' class="'.$class.'"', $content);
        }

        return '';
    }
}
