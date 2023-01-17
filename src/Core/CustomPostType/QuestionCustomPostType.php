<?php

declare(strict_types=1);

namespace App\Core\CustomPostType;

defined('ABSPATH') || exit;

use App\Bundle\RegisterHookInterface;

final class QuestionCustomPostType implements RegisterHookInterface
{
    public const NAME = 'question';

    public function registerHook(): void
    {
        add_action('init', [$this, 'init']);
        add_action('manage_' . self::NAME . '_posts_custom_column', [$this, 'columnValue'], 10, 2);
        add_filter('manage_' . self::NAME . '_posts_columns', [$this, 'newColumns']);
    }

    public function init(): void
    {
        register_post_type(self::NAME, $this->argsCustomPostType());
    }

    public function argsCustomPostType(): array
    {
        return [
            'public' => true,
            'label' => 'Pytania',
            'rewrite' => [
                'slug' => 'pytania-i-odpowiedzi',
                'with_front' => false,
            ],
            'has_archive' => false,
            'menu_icon' => 'dashicons-editor-help',
            'supports' => ['title', 'editor'],
        ];
    }

    public function columnValue(string $column, int $postId): void
    {
        switch ($column) {
            case 'like':
                the_field($column, $postId);
                break;
        }
    }

    public function newColumns(array $columns): array
    {
        $columns['like'] = 'Przydatność';

        return $columns;
    }
}
