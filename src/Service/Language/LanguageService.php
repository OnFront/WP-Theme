<?php

declare(strict_types=1);

namespace App\Service\Language;

use PLL_Language;

defined("ABSPATH") || exit;

class LanguageService
{
    private string $switch;
    private string $current;

    public function __construct()
    {
        $this->switch = pll_the_languages(
            [
                'echo' => false,
                'hide_if_no_translation' => true,
                'display_names_as' => 'slug',
                'show_flags' => false,
                'hide_current' => true,
            ]
        );

        $this->current = pll_current_language();
    }

    public function getSwitch(): array|string
    {
        return $this->switch;
    }

    public function getCurrent(): PLL_Language|bool|string
    {
        return $this->current;
    }

    public function isPL(): bool
    {
        return $this->current === LanguageType::PL;
    }

    public function isEN(): bool
    {
        return $this->current === LanguageType::EN;
    }
}
