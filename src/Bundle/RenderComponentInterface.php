<?php


namespace App\Bundle;

defined('ABSPATH') || exit;

use Timber\Post;

interface RenderComponentInterface
{
    public function __construct(Post $post, array $context = []);

    public function createView(): string;
}
