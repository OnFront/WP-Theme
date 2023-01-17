<?php

declare(strict_types=1);

namespace App\Service\Module\OptionsTheme;

defined('ABSPATH') || exit;

class Main
{
    public ?string $orderFormUrl;
    public ?string $promotionPageUrl;
    public ?string $payEyePointsUrl;
    public ?string $applicationPageUrl;

    public function __construct(array $context)
    {
        $this->orderFormUrl = $context['orderFormUrl'];
        $this->promotionPageUrl = $context['promotionPageUrl'];
        $this->payEyePointsUrl = $context['payEyePointsUrl'];
        $this->applicationPageUrl = $context['applicationPageUrl'];
    }
}
