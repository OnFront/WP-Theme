<?php

declare(strict_types=1);

namespace App\Service\Module\OptionsTheme;

defined('ABSPATH') || exit;

class Cookie
{
    private string $content;
    private string $modalContent;

    public function __construct(array $context)
    {
        $this->content = $context['content'];
        $this->modalContent = $context['modalContent'];
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getModalContent(): string
    {
        return $this->modalContent;
    }
}
