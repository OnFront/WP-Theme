<?php

declare(strict_types=1);

namespace App\Core\Post\Merchant;

use App\Core\AvailableTranslations;

defined('ABSPATH') || exit;

class Promotion
{
    private bool $isEnable;
    private array $description;
    private array $title;

    public function __construct(array $context)
    {
        $this->isEnable = $context['is_enable'] ?? false;
        $this->description = $context['description'] ?? [];
        $this->title = $context['title'] ?? [];
    }

    public function isEnable(): bool
    {
        return $this->isEnable;
    }

    public function getDescription(): AvailableTranslations
    {
        return new AvailableTranslations($this->description);
    }

    public function getTitle(): AvailableTranslations
    {
        return new AvailableTranslations($this->title);
    }
}
