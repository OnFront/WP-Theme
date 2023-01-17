<?php


namespace App\Bundle\Twig\Extension;


use App;
use App\Core\AvailableTranslations;
use App\Core\Post\MerchantPost;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TwigFilterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('t', 'pll__'),
            new TwigFilter('lang', [$this, 'trans']),
            new TwigFilter('postMerchant', [$this, 'postMerchant']),
        ];
    }

    public function trans(AvailableTranslations $translations): string
    {
        $language = App::getLanguageService();

        $context = $translations->toArray();

        return $context[$language->getCurrent()];
    }

    public function postMerchant(int $id): MerchantPost
    {
        return new MerchantPost($id);
    }
}
