<?php


namespace App\Bundle;

defined('ABSPATH') || exit;


interface RegisterHookInterface
{
    public function registerHook(): void;
}
