<?php

declare(strict_types=1);

namespace App\RestController\Controller;

defined('ABSPATH') || exit;

use App\Bundle\Framework\AbstractRestController;
use Fusonic\OpenGraph\Consumer;
use Fusonic\OpenGraph\Elements\Image;
use GuzzleHttp\Client;
use Http\Factory\Guzzle\RequestFactory;
use Psr\Http\Client\ClientExceptionInterface;
use WP_REST_Request;
use WP_REST_Response;

class DownloadMediaRestController extends AbstractRestController
{
    public function getMedium(WP_REST_Request $request): WP_REST_Response
    {
        $client = new Client();
        $consumer = new  Consumer($client, new RequestFactory());
        $response = new WP_REST_Response();

        try {
            $body = $this->getBody($request);

            $url = $body['url'] ?? '';

            $website = $consumer->loadUrl($url);

            $response->set_data(
                [
                    'imageUrl' => $this->getFirstImage($website->images) ?? 'brak zdjęcia',
                    'title' => $website->title ?? 'brak tytułu',
                ]
            );

            return $response;
        } catch (ClientExceptionInterface $e) {
            return $response;
        }
    }

    /**
     * @param Image[] $images
     * @return null|string
     */
    private function getFirstImage(array $images): ?string
    {
        if ($images) {
            return $images[0]->url;
        }

        return null;
    }
}
