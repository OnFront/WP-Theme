<?php


namespace App\Bundle\Twig\Extension;

defined('ABSPATH') || exit;


use App;
use App\Bundle\Helper\HelperSvg;
use App\Core\Post\PartnerPost;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TwigFunctionExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('breadcrumbs', [$this, 'breadcrumb']),
            new TwigFunction('svg', [$this, 'svg']),
            new TwigFunction('loadInlineCss', [$this, 'loadInlineCss']),
        ];
    }

    public function breadcrumb($before = '<div class="yoast-breadcrumb">', $after = '</div>'): string
    {
        if (function_exists('yoast_breadcrumb')) {
            return yoast_breadcrumb($before, $after, false);
        }
        return '';
    }

    public function svg(?string $svg, string $class = '', string $dataAttr = ''): string
    {
        return HelperSvg::svg($svg, $class, $dataAttr);
    }

    public function loadInlineCss()
    {
        if (!App::isDevelop()) {
            ob_start();
            ?>
            <style>
                <?php echo file_get_contents(App::path() . '/public/css/index.css'); ?>
            </style>
            <?php

            return ob_get_clean();
        }

        return '';
    }
}
