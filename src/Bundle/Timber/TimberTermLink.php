<?php

declare(strict_types=1);

namespace App\Bundle\Timber;

use App\Bundle\RegisterHookInterface;
use Timber\Term;

final class TimberTermLink implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter(
            'timber/term/link',
            static function (string $termLink, Term $term) {
                return self::generateQueryLink($term);
            },
            10,
            2
        );
    }

    public static function generateQueryLink(Term $term): string
    {
        $url = get_post_type_archive_link(get_post_type());
        $query = [
            $term->taxonomy . '_name' => $term->slug,
        ];
        $query = build_query($query);

        return $url . '?' . $query;
    }
}
