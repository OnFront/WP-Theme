<?php

declare(strict_types=1);

namespace App\Bundle\Framework;

defined('ABSPATH') || exit;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use JsonException;
use WP_REST_Request;

abstract class AbstractRestController
{
    protected function serializer($data)
    {
        $serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build();

        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $data = $serializer->serialize($data, 'json', $context);

        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
    }


    protected function getBody(WP_REST_Request $request): array
    {
        $body = $request->get_body();

        if ($body) {
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }
}
