<?php

use App\Service\CacheService;
use App\Service\CookieService;
use App\Service\Language\LanguageService;
use App\Service\LiveSpaceService;
use App\Service\LogService;
use App\Service\OptionsThemeService;
use App\Service\StoreService;
use App\Service\SwitchPayEye\SwitchPayEyeService;
use App\Service\TranslateString;
use Symfony\Component\DependencyInjection\Container;

defined('ABSPATH') || exit;

class App
{
    public static function isDevelop(): bool
    {
        return WP_DEBUG;
    }

    public static function getVersion(): string
    {
        return self::isDevelop() ? time() : wp_get_theme()->get('Version');
    }

    public static function getCacheVersion(): string
    {
        return self::getVersion().self::getLanguageService()->getCurrent();
    }

    public static function path(): string
    {
        return get_template_directory();
    }

    public static function uri(): string
    {
        return get_template_directory_uri();
    }

    public static function cachePath(): string
    {
        return self::path().'/cache';
    }

    public static function srcPath(): string
    {
        return self::path().'/src';
    }

    public static function container(): ?Container
    {
        global $container;

        return $container;
    }

    public static function getService(string $id): ?object
    {
        $containerBuilder = self::container();

        if ($containerBuilder) {
            return $containerBuilder->get($id);
        }

        return null;
    }

    public static function getSwitchPayEyeService(): SwitchPayEyeService
    {
        return self::getService(SwitchPayEyeService::class);
    }

    public static function getTranslateService(): ?TranslateString
    {
        return self::getService(TranslateString::class);
    }

    public static function getLanguageService(): LanguageService
    {
        return self::getService(LanguageService::class);
    }

    public static function getStoreService(): StoreService
    {
        return self::getService(StoreService::class);
    }

    public static function getCookieService(): CookieService
    {
        return self::getService(CookieService::class);
    }

    public static function getOptionsThemeService(): OptionsThemeService
    {
        return self::getService(OptionsThemeService::class);
    }

    public static function getCacheService(): CacheService
    {
        return self::getService(CacheService::class);
    }

    public static function getLiveSpaceService(): LiveSpaceService
    {
        return self::getService(LiveSpaceService::class);
    }

    public static function getLogService(): LogService
    {
        return self::getService(LogService::class);
    }
}
