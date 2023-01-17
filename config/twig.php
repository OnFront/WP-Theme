<?php

defined('ABSPATH') || exit;

use App\Bundle\Twig\Extension\TwigFilterExtension;
use App\Bundle\Twig\Extension\TwigFunctionExtension;
use App\Bundle\Twig\Extension\TwigGlobalExtension;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Timber\Timber;
use Twig\Environment;
use Twig\Extra\Cache\CacheExtension;
use Twig\Extra\Cache\CacheRuntime;
use Twig\TwigFunction;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

$viewDir = [
    App::path().'/templates',
    App::path().'/vendor/symfony/twig-bridge/Resources/views/Form',
];

new Timber();

Timber::$dirname = $viewDir;
Timber::$locations = $viewDir;
Timber::$cache = false;

add_filter('timber/cache/location', App::cachePath());

add_filter(
    'timber/twig',
    static function (Environment $twig): Environment {
        $twig->addFunction(new TwigFunction('asset', 'getAssetUrl'));

        if (str_contains($_SERVER['REQUEST_URI'], '/wp-json/payeye/v1/')) {
            return $twig;
        }

        $twig->addExtension(new TwigGlobalExtension());
        $twig->addExtension(new TwigFunctionExtension());
        $twig->addExtension(new TwigFilterExtension());

        $twig->addExtension(new CacheExtension());

        $twig->addRuntimeLoader(
            new class implements RuntimeLoaderInterface {
                public function load($class): CacheRuntime
                {
                    if (CacheRuntime::class === $class) {
                        return new CacheRuntime(new TagAwareAdapter(App::getCacheService()->getFilesystemAdapter()));
                    }
                }
            }
        );

        return $twig;
    }
);

function getAssetUrl(string $path): string
{
    return App::uri().'/public/'.$path;
}