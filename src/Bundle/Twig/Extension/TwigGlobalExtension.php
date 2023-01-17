<?php


namespace App\Bundle\Twig\Extension;

defined('ABSPATH') || exit;

use App;
use App\Core\NavMenus;
use Timber\Menu;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class TwigGlobalExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        $switchPayEyeService = App::getSwitchPayEyeService();

        if ($switchPayEyeService->isClient()) {
            $menuHeader = NavMenus::MENU_CLIENT;
        } else {
            $menuHeader = NavMenus::MENU_PARTNER;
        }

        $cacheService = App::getCacheService();

        $footerCache = $cacheService->getItem('footer');

        $footerMenuOne = null;
        $footerMenuTwo = null;
        $footerMenuThree = null;
        $footerMenuFour = null;
        if (!$footerCache->isHit()) {
            $footerMenuOne = new Menu('footerMenuOne');
            $footerMenuTwo = new Menu('footerMenuTwo');
            $footerMenuThree = new Menu('footerMenuThree');
            $footerMenuFour = new Menu('footerMenuFour');
        }

        return [
            'menuHeader' => new Menu($menuHeader),
            'footerMenuOne' => $footerMenuOne,
            'footerMenuTwo' => $footerMenuTwo,
            'footerMenuThree' => $footerMenuThree,
            'footerMenuFour' => $footerMenuFour,
            'store' => App::getStoreService(),
            't' => App::getTranslateService(),
            'translator' => App::getLanguageService(),
            'switchPayEyeService' => $switchPayEyeService,
            'cookie' => App::getCookieService(),
            'cacheVersion' => App::getCacheVersion(),
            'footerCache' => $footerCache,
        ];
    }
}
