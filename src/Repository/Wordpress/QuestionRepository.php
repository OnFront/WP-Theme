<?php

declare(strict_types=1);

namespace App\Repository\Wordpress;

defined("ABSPATH") || exit;

use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\CustomPostType\QuestionCustomPostType;
use App\Core\Post\MerchantPost;
use Timber\Post;
use Timber\PostQuery;
use Timber\Term;
use Timber\Timber;

final class QuestionRepository
{
    /**
     * @param string $sort
     * @return PostQuery
     */
    public function findAll(string $sort = 'DESC'): PostQuery
    {
        return new PostQuery(
            [
                'post_type' => QuestionCustomPostType::NAME,
                'posts_per_page' => -1,
                'meta_key' => 'like',
                'orderby' => 'meta_value_num',
                'order' => $sort,
            ],
        );
    }

    public function incrementLike(int $postId): int
    {
        $posts = $this->getAllPost($postId);

        $polandId = $posts['pl'];
        $post = new Post($polandId);
        $like = (int)$post->meta('like');
        $like = ++$like;

        foreach ($posts as $post) {
            $post = new Post($post);
            $post->update('like', $like);
        }

        return $like;
    }

    /**
     * @return int[]
     */
    private function getAllPost(int $postId): array
    {
        return pll_get_post_translations($postId);
    }
}
