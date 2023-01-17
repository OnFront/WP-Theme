<?php

declare(strict_types=1);

namespace App\Controller;

defined("ABSPATH") || exit;

use App;
use App\Bundle\Framework\AbstractController;
use App\Repository\Wordpress\MerchantRepository;
use App\Service\CacheService;
use Timber\Post;

class MapPointsController extends AbstractController
{
    public function __construct(private MerchantRepository $merchantRepository, private CacheService $cacheService)
    {
    }

    public function view(): string
    {
        $context = $this->context();

        $cache = $this->cacheService->getItem('list-partners-v');

        $context['cache'] = $cache;

        if (!$cache->isHit()) {
            $context['partnersPosts'] = $this->merchantRepository->findAll();
        }

        $context['partnersTerms'] = $this->merchantRepository->findAllTerms(true);

        return $this->render('pages/map-points/map-points.twig', $context);
    }
}
