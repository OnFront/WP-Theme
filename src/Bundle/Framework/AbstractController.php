<?php


namespace App\Bundle\Framework;

defined('ABSPATH') || exit;

use App;
use Timber\Timber;
use WP;

abstract class AbstractController
{
    protected function context(): array
    {
        return Timber::context();
    }

    protected function render(string $view, array $parameters = []): string
    {
        return Timber::compile($view, $parameters);
    }

    protected function getPaged(): int
    {
        global $paged;
        if (!isset($paged) || !$paged) {
            $paged = 1;
        }

        return $paged;
    }

    protected function WP(): WP
    {
        global $wp;

        return $wp;
    }
}
