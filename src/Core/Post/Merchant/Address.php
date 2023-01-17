<?php

declare(strict_types=1);

namespace App\Core\Post\Merchant;

defined('ABSPATH') || exit;

class Address
{
    private string $street;
    private string $postCode;
    private string $city;
    private string $country;

    public function __construct(array $context)
    {
        $this->street = $context['street'];
        $this->postCode = $context['post_code'];
        $this->city = $context['city'];
        $this->country = $context['country'];
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
