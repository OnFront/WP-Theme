<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Bundle\Helper\HelperDate;
use DateInterval;
use Timber\Post;

class RegulationsController extends AbstractController
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function view(): string
    {
        $post = $this->post;
        $promo = $post->meta('regulations_promo');
        $promoItems = $promo['items'] ?? [];
        $archive = [];

        $currentDate = HelperDate::currentTime();
        $days30 = new DateInterval('P30D');

        if ($promoItems) {
            foreach ($promoItems as $key => $item) {
                $expirationDate = HelperDate::createFromAcfFormat($item['expirationDate']);

                if ($currentDate > $expirationDate) {
                    unset($promo['items'][$key]);

                    if ($expirationDate->add($days30) > $currentDate) {
                        $archive[] = $item;
                    }
                }
            }
        }

        $context = $this->context();
        $context['post'] = $post;
        $context['promo'] = $promo;
        $context['archive'] = $archive;

        return $this->render('pages/regulations/regulations.twig', $context);
    }
}
