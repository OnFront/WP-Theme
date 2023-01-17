<?php

declare(strict_types=1);

namespace App\RestController\Controller;

defined('ABSPATH') || exit;

use App\Bundle\Framework\AbstractRestController;
use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\Post\MerchantPost;
use App\Repository\Wordpress\MerchantRepository;
use WP_REST_Request;
use WP_REST_Response;

class MerchantsRestController extends AbstractRestController
{
    public function __construct(private MerchantRepository $merchantRepository)
    {
    }

    public function getMerchants(WP_REST_Request $request): WP_REST_Response
    {
        $response = new WP_REST_Response();

        $terms = $request->get_param('terms') ?: [];
        if ($terms) {
            $terms = explode(',', $terms);
        }

        $isPromo = $request->get_param('promo') ?? false;
        $isPromo = (bool)$isPromo;

        if ($terms || $isPromo) {
            $merchants = $this->merchantRepository->findByTermIdsAndByIsPromo($terms, $isPromo)->get_posts();
        } else {
            $merchants = $this->merchantRepository->findAll()->get_posts();
        }

        $data = $this->getMerchantsData($merchants);
        $response->set_data($data);

        return $response;
    }

    public function getMerchant(WP_REST_Request $request): WP_REST_Response
    {
        $response = new WP_REST_Response();

        $id = $request->get_param('id');

        $merchant = new MerchantPost($id);

        if ($merchant->post_type === MerchantsCustomPostType::NAME) {
            $merchant = new MerchantPost($id);

            $data = [
                'title' => $merchant->title(),
                'promotion' => $this->serializer($merchant->getPromotion()),
                'branches' => $this->serializer($merchant->getBranches()),
            ];
        } else {
            $data = [
                'code' => 404,
            ];
        }

        $response->set_data($data);

        return $response;
    }

    /**
     * @param MerchantPost[] $merchants
     * @return MerchantPost[]
     */
    private function getMerchantsData(array $merchants): array
    {
        $data = [];

        foreach ($merchants as $merchant) {
            $data[] = [
                'id' => $merchant->ID,
                'title' => $merchant->title(),
                'logo' => $merchant->logo()['url'] ?? null,
                'imageUrl' => $merchant->imageUrl(),
                'category' => [
                    'pl' => $merchant->category()->name,
                    'en' => $merchant->category()->meta('title')['en'],
                ],
                'promotion' => $this->serializer($merchant->getPromotion()),
                'branches' => $this->serializer($merchant->getBranches()),
            ];
        }

        return $data;
    }
}
