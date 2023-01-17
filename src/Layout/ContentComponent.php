<?php

declare(strict_types=1);

namespace App\Layout;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Bundle\RenderComponentInterface;
use Timber\Post;

class ContentComponent extends AbstractController implements RenderComponentInterface
{
    private array $context;
    private Post $post;

    public function __construct(Post $post, array $context = [])
    {
        $this->context = $context;
        $this->post = $post;
    }

    public function createView(): string
    {
        $context = $this->context;
        $context['post'] = $this->post;

        $youTube = $this->context['acf']['youtube'] ?? '';

        if ($youTube) {
            $youTube = str_replace('https://www.youtube.com/watch?v=', '', $youTube);
            $context['youTube'] = $youTube;
        }

        return $this->render('elastic_layout/el_content.twig', $context);
    }
}
