<?php

defined('ABSPATH') || exit;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$isDebug = WP_DEBUG;

$file = App::cachePath() . '/container.php';
$containerConfigCache = new ConfigCache($file, $isDebug);

if (!$containerConfigCache->isFresh()) {
    $containerBuilder = new ContainerBuilder();

    $loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
    $loader->load('services.yaml');

    $containerBuilder->compile();

    $dumper = new PhpDumper($containerBuilder);
    $containerConfigCache->write(
        $dumper->dump(),
        $containerBuilder->getResources()
    );
}

require_once $file;

return $container = new ProjectServiceContainer();
