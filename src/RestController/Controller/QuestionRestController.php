<?php

namespace App\RestController\Controller;

use App\Bundle\Framework\AbstractRestController;
use App\Repository\Wordpress\QuestionRepository;
use WP_REST_Request;
use WP_REST_Response;

class QuestionRestController extends AbstractRestController
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function like(WP_REST_Request $request): WP_REST_Response
    {
        $postId = $request->get_param('postId');

        $response = new WP_REST_Response();

        $count = $this->questionRepository->incrementLike($postId);
        $response->set_data(
            [
                'count' => $count,
            ]
        );

        return $response;
    }
}
