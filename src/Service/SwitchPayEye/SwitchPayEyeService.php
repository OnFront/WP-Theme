<?php

declare(strict_types=1);

namespace App\Service\SwitchPayEye;

use App\Service\CookieService;
use App\Service\Language\LanguageService;
use App\Service\Language\LanguageType;

class SwitchPayEyeService
{
    private bool $isClient;
    private bool $isPartner;

    private string $findKey;

    private string $clientZone = 'strefa-klienta';
    private string $searchSlug = 'strefa-biznesu';

    public function __construct(CookieService $cookieService, LanguageService $languageService)
    {
        $path = $_SERVER['REQUEST_URI'];

        $this->isClient = !$this->isParentSlug($path);
        $this->isPartner = $this->isParentSlug($path);

        $this->findKey = $this->isPartner ? SwitchPayEyeType::BUSINESS : SwitchPayEyeType::CLIENT;

        switch ($cookieService->getTypeAccount()) {
            case SwitchPayEyeType::CLIENT:
                $this->isClient = true;
                $this->isPartner = false;
                break;
            case SwitchPayEyeType::BUSINESS:
                $this->isClient = false;
                $this->isPartner = true;
                break;
        }

        if ($languageService->getCurrent() === LanguageType::EN) {
            $this->searchSlug = 'business-zone';
            $this->clientZone = 'customer-zone';
        }
    }

    private function isParentSlug(string $path): bool
    {
        return str_contains($path, $this->searchSlug);
    }

    public function getFindKey(): string
    {
        return $this->findKey;
    }

    public function isClient(): bool
    {
        return $this->isClient;
    }

    public function isPartner(): bool
    {
        return $this->isPartner;
    }

    public function getPartnerSlug(): string
    {
        return $this->searchSlug;
    }

    public function getClientZone(): string
    {
        return $this->clientZone;
    }
}
