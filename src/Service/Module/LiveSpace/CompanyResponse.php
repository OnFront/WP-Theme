<?php

declare(strict_types=1);

namespace App\Service\Module\LiveSpace;

defined('ABSPATH') || exit;

class CompanyResponse
{
    private string $uid;
    private string $url;

    public function __construct(array $responseData)
    {
        $company = $responseData['company'] ?? [];

        $this->uid = $company['id'] ?? '';
        $this->url = 'https://payeye.livespace.io/Contact/company/details/api_id/'.$this->uid;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
