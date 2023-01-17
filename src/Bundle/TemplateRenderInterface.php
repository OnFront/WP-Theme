<?php


namespace App\Bundle;

defined('ABSPATH') || exit;

interface TemplateRenderInterface
{
    public function view(): string;
}
