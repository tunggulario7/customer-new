<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CustomerModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class CustomerController extends Controller
{

    public function insert(Request $request, Response $response): Response
    {
        $customerValidation = new CustomerModel();
        $validation = $customerValidation->validate($request->getParsedBody(), $response);

        if($validation) {
            //Get Base Directory
            $dir = explode("/", __DIR__);
            $countSlice = count($dir) - 2;
            $sliceDir = array_slice($dir, 0, $countSlice);
            $impDir = implode("/", $sliceDir);

            //Create File in Public Directory
            $fileName = $impDir . "/public/export/data-customer.txt";
            $data = $validation['name'] . "|" . $validation['ktp'] . "|" . $validation['loanAmount'] . "|" . $validation['loanPeriod'] . "|" . $validation['loanPurpose'] . "|" . $validation['dateOfBirth'] . "|" . $validation['sex'] . PHP_EOL;
            file_put_contents($fileName, $data, FILE_APPEND);
        }

        $response->getBody()->write(json_encode($validation));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
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

        $dataJson = array();
        $explodeRow = explode(PHP_EOL, $data);
        foreach ($explodeRow as $row) {
            if ($row) {
                $expColumn = explode('|', $row);
                array_push($dataJson, [
                    "name" => $expColumn[0],
                    "ktp" => $expColumn[1],
                    "loanAmount" => $expColumn[2],
                    "loanPeriod" => $expColumn[3],
                    "loanPurpose" => $expColumn[4],
                    "dateOfBirth" => $expColumn[5],
                    "sex" => $expColumn[6]
                ]);
            }
        }

        $response->getBody()->write(json_encode($dataJson));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}