<?php

declare(strict_types=1);

namespace App\Bundle\Helper;

use DateTime;
use Exception;

defined("ABSPATH") || exit;

abstract class HelperDate
{
    public static function currentTime(): DateTime
    {
        $now = current_time('Y-m-d H:i:s');

        try {
            $now = new DateTime($now);
        } catch (Exception $e) {
        }

        return $now;
    }

    public static function createFromAcfFormat(string $date): DateTime
    {
        $acfFormat = 'd/m/Y';

        return DateTime::createFromFormat($acfFormat, $date);
    }
}
