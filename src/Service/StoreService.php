<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\SwitchPayEye\SwitchPayEyeService;

defined("ABSPATH") || exit;

class StoreService
{
    public string $facebook = 'https://www.facebook.com/PayEyeWorld/';
    public string $instagram = 'https://www.instagram.com/payeyepoland/';
    public string $twitter = 'https://twitter.com/PayEyePoland';
    public string $linkedin = 'https://www.linkedin.com/company/payeye/';

    public string $appleLink = 'https://apps.apple.com/pl/app/payeye-2-0/id1628561744';
    public string $gogglePlayLink = 'https://play.google.com/store/apps/details?id=com.payeye.passwallet';
    public string $appGalleryLink = 'https://appgallery.huawei.com/#/app/C106413423';

    public string $siteUrl;
    public string $frontPageUrl;

    public ?string $joinUs;

    public string $googleMapKey = 'AIzaSyAa0KFsYaLcAAgf0uLxOsAGFsz8aSpbG30';
    public string $analyticsId = 'UA-148337138-1';

    public OptionsThemeService $theme;

    public function __construct(OptionsThemeService $optionsThemeService, SwitchPayEyeService $switchPayEyeService)
    {
        $this->theme = $optionsThemeService;

        $this->siteUrl = pll_home_url();
        $this->frontPageUrl = pll_home_url();

        if ($switchPayEyeService->isPartner()) {
            $this->joinUs = $optionsThemeService->getMain()->orderFormUrl;
        } else {
            $this->joinUs = $optionsThemeService->getMain()->applicationPageUrl;
        }
    }
}
