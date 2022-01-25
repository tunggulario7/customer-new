<?php

namespace Tests\Application\Actions\Customer;

use Tests\TestCase;
use App\Controllers\CustomerController;

class CustomerTest extends TestCase
{

    public function testInsertData() {
        //Define Json Body
        $bodyJson = [
            'name' => "Lorem Ipsum",
            'ktp' => 12334568907,
            'loanAmount' => 5000,
            'loanPeriod' => 12,
            'loanPurpose' => "vacation",
            'dateOfBirth' => "2000-01-24",
            'sex' => "Male",
        ];


        //Create Request Body
        $requestBody = $this->createRequest('POST', '/customer', ['Content-Type' => 'application/json']);
        $json = $requestBody->withParsedBody($bodyJson);

        $response = New \Slim\Psr7\Response();

        $customer = new CustomerController();
        $responseData = $customer->insert($json, $response);

        $this->assertEquals(200, $responseData->getStatusCode());
        $this->assertEquals(json_encode($bodyJson), $responseData->getBody());
    }

    public function testGetData() {
        //Define Json Body
        $requestBody = $this->createRequest('GET', '/customer', ['Content-Type' => 'application/json']);

        $response = New \Slim\Psr7\Response();

        $customer = new CustomerController();
        $responseData = $customer->get($requestBody, $response);

        $this->assertEquals(200, $responseData->getStatusCode());
    }

}