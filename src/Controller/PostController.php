<?php

declare(strict_types=1);

namespace App\Controller;

defined('ABSPATH') || exit;

use App\Bundle\Framework\AbstractController;
use App\Bundle\Wordpress\ElasticLayout;
use Timber\Post;
use Timber\PostQuery;

class PostController extends AbstractController
{
    private Post $post;
    private ElasticLayout $elasticLayout;

    public function __construct(Post $post, ElasticLayout $elasticLayout)
    {
        $this->post = $post;
        $this->elasticLayout = $elasticLayout;
    }

    public function view(): string
    {
        $post = $this->post;
        $context = $this->context();

        $this->elasticLayout
            ->setClassName('section-post')
            ->createView();

        $context['post'] = $post;
        $context['elasticLayout'] = $this->elasticLayout;
        $context['archiveUrl'] = get_post_type_archive_link('post');

        return $this->render('pages/post/index.twig', $context);
    }
}
