<?php

declare(strict_types=1);

namespace App\Bundle\Helper;

use App;
use ReflectionClass;

defined('ABSPATH') || exit;


abstract class HelperController
{
    public static function findNamespaceController(string $pageTemplate): string
    {
        $wpPage = str_replace('.php', '', $pageTemplate);

        return 'App\Controller\\' . $wpPage;
    }

    public static function getTemplateFile(string $className): string
    {
        $class = (new ReflectionClass($className))->getFileName();
        $dirname = pathinfo($class);

        return $dirname['basename'];
    }
}
