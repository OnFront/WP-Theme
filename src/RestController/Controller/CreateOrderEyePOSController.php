<?php

namespace App\RestController\Controller;

use App\RestController\Model\CreateOrderEyePOS;
use App\Service\Email\EmailService;
use App\Service\LiveSpaceService;
use App\Service\LogService;
use App\Service\Module\LiveSpace\CompanyResponse;
use Livespace\LivespaceException;
use Livespace\LivespaceSerializeException;
use WP_HTTP_Response;
use WP_REST_Request;
use WP_REST_Response;

class CreateOrderEyePOSController
{
    public function __construct(private LiveSpaceService $liveSpaceService, private LogService $logService, private EmailService $emailService)
    {
    }

    public function create(WP_REST_Request $request): WP_HTTP_Response
    {
        $response = new WP_REST_Response();
        $data = new CreateOrderEyePOS($request);

        try {
            $result = $this->liveSpaceService->addCompanyData($data);

            if (!$result->getStatus()) {
                $this->logService->add('Błąd integracji', json_encode($result, JSON_THROW_ON_ERROR));

                throw new LivespaceException("Błąd integracji");
            }

            $company = new CompanyResponse($result->getData());
            $this->liveSpaceService->addDeal($company, $data);

            $this->emailService->autoResponse($data->getEmail());
            $this->emailService->eyePOSOrdered($company->getUrl());


            return $response;
        } catch (LivespaceSerializeException|LivespaceException $exception) {
            $log = [
                'title' => 'LiveSpace: '.$exception->getMessage(),
                'content' => json_encode($request->get_params(), JSON_THROW_ON_ERROR),
            ];

            $this->logService->add($log['title'], $log['content']);
            $response->set_status(400);
        }

        return $response;
    }
}
