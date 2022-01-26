<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CustomerModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CustomerController extends Controller
{

    public function insert(Request $request, Response $response): Response
    {
        $requestBody = $request->getParsedBody();
        $customerValidation = new CustomerModel();
        $validation = $customerValidation->validate($requestBody);

        //Decalre Variable for Return Response
        $returnBody = '{
                    "status": "OK",
                    "message": "Success"
                }';
        $statusCode = 200;

        if (empty($validation)) {
            //Get Base Directory
            $dir = explode("/", __DIR__);
            $countSlice = count($dir) - 2;
            $sliceDir = array_slice($dir, 0, $countSlice);
            $impDir = implode("/", $sliceDir);

            //Create File in Public Directory
            $fileName = $impDir . "/public/export/data-customer.txt";
            $data = $requestBody['name'] . "|" . $requestBody['ktp'] . "|" . $requestBody['loanAmount'] . "|" . $requestBody['loanPeriod'] . "|" . $requestBody['loanPurpose'] . "|" . $requestBody['dateOfBirth'] . "|" . $requestBody['sex'] . PHP_EOL;
            file_put_contents($fileName, $data, FILE_APPEND);
        } else {
            $returnBody = json_encode($validation);
            $statusCode = 422;
        }

        $response->getBody()->write($returnBody);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    public function get(Request $request, Response $response)
    {

        //Get Base Directory
        $dir = explode("/", __DIR__);
        $countSlice = count($dir) - 2;
        $sliceDir = array_slice($dir, 0, $countSlice);
        $impDir = implode("/", $sliceDir);

        //Create File in Public Directory
        $fileName = $impDir . "/public/export/data-customer.txt";
        $file = fopen($fileName, "r");
        $data = fread($file, filesize($fileName));
        fclose($file);

        $dataJson = [];
        $explodeRow = explode(PHP_EOL, $data);
        foreach ($explodeRow as $row) {
            if ($row) {
                $expColumn = explode('|', $row);
                $dataJson[] = [
                    "name" => $expColumn[0],
                    "ktp" => $expColumn[1],
                    "loanAmount" => $expColumn[2],
                    "loanPeriod" => $expColumn[3],
                    "loanPurpose" => $expColumn[4],
                    "dateOfBirth" => $expColumn[5],
                    "sex" => $expColumn[6]
                ];
            }
        }

        $response->getBody()->write(json_encode($dataJson));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
