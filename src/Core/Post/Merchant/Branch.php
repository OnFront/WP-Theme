<?php

declare(strict_types=1);

namespace App\Core\Post\Merchant;

use App;
use App\Core\AvailableTranslations;

defined('ABSPATH') || exit;

final class Branch
{
    private string $id;
    private string $googleMapUrl;
    private Location $location;
    private bool $isDisablePromotion;
    private bool $isDisableBranch;
    private Address $address;
    private AvailableTranslations $websiteUrl;

    public function __construct(array $context)
    {
        $this->id = $context['id'];
        $this->googleMapUrl = $context['google_map_url'];
        $this->location = new Location($context['location']);
        $this->isDisablePromotion = $context['is_disable_promotion'];
        $this->isDisableBranch = $context['is_disable_branch'];
        $this->address = new Address($context['address']);
        $this->websiteUrl = new AvailableTranslations($context['partner_url']);

        if (!$this->googleMapUrl) {
            $location = $this->getLocation();

            $this->googleMapUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . $location->getLatitude() . ',' . $location->getLongitude();
        }
    }

    public function getGoogleMapUrl(): string
    {
        return $this->googleMapUrl;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function isDisablePromotion(): bool
    {
        return $this->isDisablePromotion;
    }

    public function isDisableBranch(): bool
    {
        return $this->isDisableBranch;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWebsiteUrl(): AvailableTranslations
    {
        return $this->websiteUrl;
    }
}
