<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CustomerModel;
use App\Validations\CustomerValidation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class CustomerController extends Controller
{

    public function insert(Request $request, Response $response)
    {
        $customerValidation = new CustomerModel();
        $validation = $customerValidation->validate($request->getParsedBody(), $response);

        if($validation) {
            //Get Base Directory
            $dir = explode("/", __DIR__);
            $sliceDir = array_slice($dir, 0, 3);
            $impDir = implode("/", $sliceDir);

            //Create File in Public Directory
            $fileName = $impDir . "/public/export/" . $validation['ktp'] . "-" . $validation['name'] . ".txt";
            $file = fopen($fileName, "w");
            $data = $validation['name'] . "|" . $validation['ktp'] . "|" . $validation['loanAmount'] . "|" . $validation['loanPeriod'] . "|" . $validation['loanPurpose'] . "|" . $validation['dateOfBirth'] . "|" . $validation['sex'];
            fwrite($file, $data);
            fclose($file);
        }

        $response->getBody()->write(json_encode($validation));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}