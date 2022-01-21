<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Validations\CustomerValidation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class CustomerController extends BaseController
{

    public function send(Request $request, Response $response)
    {
        $customerValidation = new CustomerValidation();
        $validation = $customerValidation->validate($request->getParsedBody());
        $response->getBody()->write(json_encode($validation));
        return  $response;
    }

}