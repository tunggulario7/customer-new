<?php

namespace Tests\Application\Actions\Customer;

use Tests\TestCase;
use App\Controllers\CustomerController;

class CustomerTest extends TestCase
{


    public function testInsertDataProvider(): array
    {
        return [
            [
                [
                    'name' => "Lorem Ipsum",
                    'ktp' => 12334568907,
                    'loanAmount' => "5000",
                    'loanPeriod' => 12,
                    'loanPurpose' => "vacation",
                    'dateOfBirth' => "2000-01-24",
                    'sex' => "Male",
                ], 200,
                '{
                    "status": "OK",
                    "message": "Success"
                }'
            ],
        ];
    }

    /** @dataProvider testInsertDataProvider */
    public function testInsertData(array $bodyJson, int $expectedStatusCode, string $expectedResponse)
    {
        //Create Request Body
        $requestBody = $this->createRequest('POST', '/customer', ['Content-Type' => 'application/json']);
        $json = $requestBody->withParsedBody($bodyJson);

        $response = new \Slim\Psr7\Response();

        $customer = new CustomerController();
        $responseData = $customer->insert($json, $response);

        $responseArray = json_decode($responseData->getBody(), true);

        $this->assertEquals($expectedStatusCode, $responseData->getStatusCode());
        $this->assertEquals(json_decode($expectedResponse, true), $responseArray);
    }

    public function testGetData()
    {
        //Define Json Body
        $requestBody = $this->createRequest('GET', '/customer', ['Content-Type' => 'application/json']);

        $response = new \Slim\Psr7\Response();

        $customer = new CustomerController();
        $responseData = $customer->get($requestBody, $response);

        $this->assertEquals(200, $responseData->getStatusCode());
    }
}
