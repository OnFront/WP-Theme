<?php

declare(strict_types=1);

namespace App\Bundle\Polylang;

use App;
use App\Bundle\RegisterHookInterface;

final class PolylangRegisterString implements RegisterHookInterface
{
    public function registerHook(): void
    {
        if (function_exists('pll_register_string')) {
            add_action(
                'init',
                function () {
                    $translate = App::getTranslateService();
                    $context = 'payeye';

                    if ($translate) {
                        $vars = get_object_vars($translate);

                        foreach ($vars as $name => $trans) {
                            pll_register_string($name, $trans, $context);
                        }
                    }
                }
            );
        }
    }
}
