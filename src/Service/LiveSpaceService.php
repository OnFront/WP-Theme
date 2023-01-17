<?php

declare(strict_types=1);

namespace App\Service;

defined('ABSPATH') || exit;

use App\RestController\Model\CreateOrderEyePOS;
use App\Service\Module\LiveSpace\CompanyResponse;
use Livespace\Livespace;
use Livespace\LivespaceException;
use Livespace\LivespaceResponse;
use Livespace\LivespaceSerializeException;

class LiveSpaceService
{
    private const API_URL = 'https://payeye.livespace.io';

    // USER API
    private const API_KEY = '303d8njnn3gssgq0i2ug1ppu1cgxlp';
    private const API_SECRET = 'wopz2ynllap13hi';

    // Karolina Wierciuch
    private const API_ADMIN_KEY = '0azgmp35l9sopn4pum51idlijo5cvg';
    private const API_ADMIN_SECRET = '2vr1bdqficob1ez';

    private const SOURCE_API = 'Formularz zamówienia WWW';

    private Livespace $liveSpace;

    public function __construct()
    {
        $data = [
            'api_url' => self::API_URL,
            'api_key' => self::API_KEY,
            'api_secret' => self::API_SECRET,
        ];

        $this->liveSpace = new LiveSpace($data);
    }

    /**
     * @throws LivespaceSerializeException|LivespaceException
     */
    public function getCompany(string $uid): LivespaceResponse
    {
        $data = [
            'type' => 'company',
            'id' => $uid,
        ];

        return $this->liveSpace->call('Contact/get', $data);
    }

    /**
     * @throws LivespaceSerializeException|LivespaceException
     */
    public function addCompanyData(CreateOrderEyePOS $contactFormData): LivespaceResponse
    {
        $industry = [
            'id' => 'ea1662d4-2e2e-f57a-ea14-3b68d71f715e',
            'items' => [
                'gastronomy' => 'dc22787a-bff9-d153-30fa-ad667f48a753',
                'trade' => '1c8c833a-f388-ced8-edb5-1ca134f8e399',
                'services' => 'ecb5b982-6a56-bb85-2235-cef9d704176a',
                'mediation' => 'dcfa4b6c-3207-40b9-8735-b3a3132050ab',
                'other' => '35c59b7b-6283-5a1f-5512-3804b2b8efd6',
            ],
        ];

        $budget = [
            'id' => 'fc255bee-dff3-de1c-2604-264a5fea3c8e',
            'items' => [
                'low' => '566e237c-ceec-3d05-c830-552a2056464a',
                'medium' => 'c14c710f-c71b-3e1d-7300-35dfb63f8c22',
                'high' => '3e4e3fac-9746-7869-c9d5-2f171f4771b7',
            ],
        ];

        $branch = [
            'id' => '1161f4ea-566b-9553-f6ab-97485ee9fb1b',
            'items' => [
                'branch' => 'a21bf12f-406a-bfd4-5da5-21a1793f695f',
                'central' => 'd4f2b6bc-e62f-fbd7-8d80-14a2a6c1faa5',
            ],
        ];

        $data = [
            'company' => [
                'name' => $contactFormData->getCompanyName(),
                'nip' => $contactFormData->getNip(),
                'company_source' => self::SOURCE_API,
                'emails' => [
                    [
                        'email' => $contactFormData->getEmail(),
                        'is_default' => 1,
                    ],
                ],
                'phones' => [
                    [
                        'phone_no' => $contactFormData->getPhone(),
                        'type' => 1,
                    ],
                ],
                'addresses' => [
                    [
                        'city' => $contactFormData->getCity(),
                        'province' => $contactFormData->getProvince(),
                    ],
                ],
                'dataset' => [
                    $industry['id'] => $industry['items'][$contactFormData->getIndustry()],
                    $budget['id'] => $budget['items'][$contactFormData->getBudget()],
                    $branch['id'] => $branch['items']['central'],
                ],
            ],
        ];

        return $this->liveSpace->call('Contact/addCompany', $data);
    }

    /**
     * @throws LivespaceSerializeException|LivespaceException
     */
    public function addDeal(CompanyResponse $companyResponse, CreateOrderEyePOS $contactFormData): LivespaceResponse
    {
        $appearanceId = '7a90489f-08ef-5905-0207-e0503cfc0616';
        $informationFromWWW = 'b2365eea-1607-bffb-2ae5-f275505773ce';

        $product = [
            'pos' => '6478ce82-e7ee-11fb-f018-ee698e7be9f1',
            'pos-stand' => '2243d181-72de-3a89-4f0b-62727e81c680',
        ];

        $price = [
            'pos' => '9,90',
            'pos-stand' => '9,90',
        ];

        $dealData = [
            'deal' => [
                'name' => self::SOURCE_API,
                'deal_source' => self::SOURCE_API,
                'created' => current_datetime()->format('Y-m-d H:i:s'),
                'company' => [
                    'id' => $companyResponse->getUid(),
                ],
                'contact' => [
                    'name' => $contactFormData->getFullName(),
                    'contact_source' => self::SOURCE_API,
                    'emails' => [
                        [
                            'email' => $contactFormData->getEmail(),
                        ],
                    ],
                    'phones' => [
                        [
                            'phone_no' => $contactFormData->getPhone(),
                            'type' => 1,
                        ],
                    ],
                    'addresses' => [
                        [
                            'city' => $contactFormData->getCity(),
                            'province' => $contactFormData->getProvince(),
                        ],
                    ],
                ],
                'budget' => [
                    [
                        'product_id' => $product[$contactFormData->getProduct()],
                        'value' => $price[$contactFormData->getProduct()],
                    ],
                ],
                'dataset' => [
                    $appearanceId => $contactFormData->isAcceptance(),
                    $informationFromWWW => 'Liczba terminali: '.$contactFormData->getCountTerminal().'. Liczba punktów: '.$contactFormData->getCountPoint().'.',
                ],
            ],
        ];

        return $this->liveSpace->call('Deal/addDeal', $dealData);
    }
}
