<?php


namespace App\Bundle\Polylang;


use App\Bundle\RegisterHookInterface;

final class PolylangFrontPageACF implements RegisterHookInterface
{
    private bool $filtered = false;

    public function registerHook(): void
    {
        add_filter('acf/location/rule_match/page_type', array($this, 'hook_page_on_front'));
    }

    public function hook_page_on_front($match)
    {
        if (!$this->filtered) {
            add_filter('option_page_on_front', array($this, 'translate_page_on_front'));

            $this->filtered = true;
        }

        return $match;
    }

    public function translate_page_on_front($value)
    {
        if (function_exists('pll_get_post')) {

            $value = pll_get_post($value);
        }

        return $value;
    }
}
