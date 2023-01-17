<?php

declare(strict_types=1);

namespace App\Service;

defined('ABSPATH') || exit;

class CookieService
{
    private string $typeAccount;
    private bool $isActiveAnalytics;
    private bool $isActiveAds;
    private $questions;

    public function __construct()
    {
        $this->typeAccount = $_COOKIE['type-account'] ?? '';
        $this->isActiveAnalytics = (bool)($_COOKIE['active-analytics'] ?? '');
        $this->isActiveAds = (bool)($_COOKIE['active-ads'] ?? '');
        $this->questions = $_COOKIE['questions'] ?? [];
    }

    public function getTypeAccount(): string
    {
        return $this->typeAccount;
    }

    public function setCookieTypeAccount(string $value): void
    {
        $oneDay = 86400;

        setcookie('type-account', $value, time() + $oneDay, '/');
    }

    public function isActiveAnalytics(): bool
    {
        return $this->isActiveAnalytics;
    }

    public function isActiveAds(): bool
    {
        return $this->isActiveAds;
    }

    public function getQuestions(): array
    {
        $questions = $this->questions;

        if (is_string($questions)) {
            $questions = json_decode(html_entity_decode(stripslashes($questions)), true, 512, JSON_THROW_ON_ERROR);
        }

        return $questions;
    }
}
