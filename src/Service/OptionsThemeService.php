<?php

declare(strict_types=1);

namespace App\Service;

use App;
use App\Service\Module\OptionsTheme\Cookie;
use App\Service\Module\OptionsTheme\Footer;
use App\Service\Module\OptionsTheme\Main;

defined("ABSPATH") || exit;

class OptionsThemeService
{
    private Cookie $cookie;
    private Footer $footer;
    private Main $main;

    public function __construct()
    {
        $context = get_fields('options');

        $this->cookie = new Cookie($context['cookie']);
        $this->footer = new Footer($context['footer']);
        $this->main = new Main($context['main']);
    }

    public function getCookie(): Cookie
    {
        return $this->cookie;
    }

    public function getFooter(): Footer
    {
        return $this->footer;
    }

    public function getMain(): Main
    {
        return $this->main;
    }
}
