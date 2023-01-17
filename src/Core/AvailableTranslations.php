<?php

declare(strict_types=1);

namespace App\Core;

use App;

defined('ABSPATH') || exit;

final class AvailableTranslations
{
    private string $pl;
    private string $en;

    public function __construct(array $context)
    {
        $this->pl = $context['pl'] ?? '';
        $this->en = $context['en'] ?? '';
    }

    public function __toString(): string
    {
        return $this->toArray()[App::getLanguageService()->getCurrent()];
    }

    public function toArray(): array
    {
        return [
            'pl' => $this->getPl(),
            'en' => $this->getEn(),
        ];
    }

    public function getPl(): string
    {
        return $this->pl;
    }

    public function getEn(): string
    {
        return $this->en;
    }
}
