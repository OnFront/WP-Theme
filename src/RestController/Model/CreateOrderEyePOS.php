<?php

declare(strict_types=1);

namespace App\RestController\Model;

use WP_REST_Request;

defined('ABSPATH') || exit;

class CreateOrderEyePOS
{
    private int $countTerminal;
    private int $countPoint;
    private string $fullName;
    private string $phone;
    private string $email;
    private string $nip;
    private string $companyName;
    private string $city;
    private string $province;
    private string $industry;
    private string $budget;
    private string $product;
    private bool $isAcceptance;

    public function __construct(WP_REST_Request $request)
    {
        $this->countTerminal = $request->get_param('countTerminal');
        $this->countPoint = $request->get_param('countPoint');
        $this->fullName = $request->get_param('fullName');
        $this->phone = $request->get_param('mobileNo');
        $this->email = $request->get_param('email');
        $this->nip = $request->get_param('taxId');
        $this->companyName = $request->get_param('companyName');
        $this->city = $request->get_param('location');
        $this->province = $request->get_param('region');
        $this->industry = $request->get_param('sector');
        $this->budget = $request->get_param('turnover');
        $this->product = 'pos';
        $this->isAcceptance = $request->get_param('term1');
    }

    public function getCountTerminal(): int
    {
        return $this->countTerminal;
    }

    public function getCountPoint(): int
    {
        return $this->countPoint;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getProvince(): string
    {
        return $this->province;
    }

    public function getIndustry(): string
    {
        return $this->industry;
    }

    public function getBudget(): string
    {
        return $this->budget;
    }

    public function getProduct(): string
    {
        return $this->product;
    }

    public function isAcceptance(): bool
    {
        return $this->isAcceptance;
    }
}
