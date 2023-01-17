<?php

declare(strict_types=1);

namespace App;

defined('ABSPATH') || exit;

use App\Bundle\Acf\AcfFieldInit;
use App\Bundle\CF7\NipFieldCF7;
use App\Bundle\ClearCache\ClearCache;
use App\Bundle\Orphans\Orphans;
use App\Bundle\Polylang\PolylangFrontPageACF;
use App\Bundle\Polylang\PolylangRegisterString;
use App\Bundle\Polylang\PolylangSlug;
use App\Bundle\Timber\TimberTermLink;
use App\Bundle\Wordpress\Clean;
use App\Bundle\Wordpress\ProtectionForm;
use App\Core\CustomPostType\FaqCustomPostType;
use App\Core\CustomPostType\LogCustomPostType;
use App\Core\CustomPostType\MediaCustomPostType;
use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\CustomPostType\QuestionCustomPostType;
use App\Core\Enqueue;
use App\Core\NavMenus;
use App\Core\ThemeSupport;
use App\Form\ContactForm;
use App\RestController\RegisterRestController;

final class InitHooks
{
    private static function getHooks(): array
    {
        return [
            AcfFieldInit::class,
            NipFieldCF7::class,
            Clean::class,
            Enqueue::class,
            ThemeSupport::class,
            NavMenus::class,
            PolylangSlug::class,
            PolylangRegisterString::class,
            PolylangFrontPageACF::class,
            FaqCustomPostType::class,
            MediaCustomPostType::class,
            MerchantsCustomPostType::class,
            TimberTermLink::class,
            RegisterRestController::class,
            ClearCache::class,
            Orphans::class,
            LogCustomPostType::class,
            ContactForm::class,
            QuestionCustomPostType::class,
            ProtectionForm::class,
        ];
    }

    public static function registerHooks(): void
    {
        foreach (self::getHooks() as $class) {
            $service = new $class();

            if (method_exists($service, 'registerHook')) {
                $service->registerHook();
            }
        }
    }
}
