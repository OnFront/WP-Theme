<?php

declare(strict_types=1);

namespace App\Core\Post\Merchant;

defined('ABSPATH') || exit;

final class Location
{
    private float $latitude;
    private float $longitude;

    public function __construct(array $context)
    {
        $this->latitude = (float)$context['latitude'];
        $this->longitude = (float)$context['longitude'];
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
