<?php

declare(strict_types=1);

namespace App\Service\Module\OptionsTheme;

defined('ABSPATH') || exit;

class Footer
{
    private ?string $donationPageUrl;
    private ?string $isoCertPageUrl;

    public function __construct(array $context)
    {
        $this->donationPageUrl = $context['donationPage'];
        $this->isoCertPageUrl = $context['isoCertPage'];
    }

    public function getDonationPageUrl(): ?string
    {
        return $this->donationPageUrl;
    }

    public function isoCertPageUrl(): ?string
    {
        return $this->isoCertPageUrl;
    }
}
