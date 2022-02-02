<?php

//declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Controller;
use App\Factory\QueryFactory;
use App\Models\CustomerModel;
use App\Repository\CustomerRepository;
use Cake\Core\ContainerInterface;
use Cake\Database\Connection;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CustomerController
{
//    public CustomerRepository $repository;
//
//    /**
//     * The constructor.
//     *
//     * @param CustomerRepository $repository The repository
//     */
//    public function __construct(CustomerRepository $repository)
//    {
//        $this->repository = $repository;
//    }

//    public function __invoke(
//        Request $request,
//        Response $response
//    ): Response {
//
//        // Invoke the domain (service class)
//        $user = $this->repository->selectCustomer();
//
//        // Transform result
//        return $this->getCustomer($response, $user);
//    }

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

    public function getCustomer(Request $request, Response $response): Response
    {
        $customerRepo = new CustomerRepository(new QueryFactory(new Connection([
            'driver' => \Cake\Database\Driver\Mysql::class,
            'host' => '127.0.0.1',
            'port' => 3357,
            'database' => 'Tunaiku_Loan',
            'username' => 'root',
            'password' => 'admin123',
            'encoding' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            // Enable identifier quoting
            'quoteIdentifiers' => true,
            // Set to null to use MySQL servers timezone
            'timezone' => null,
            // PDO options
            'flags' => [
                // Turn off persistent connections
                PDO::ATTR_PERSISTENT => false,
                // Enable exceptions
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Emulate prepared statements
                PDO::ATTR_EMULATE_PREPARES => true,
                // Set default fetch mode to array
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Set character set
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
            ]
        ])));
        $data = $customerRepo->selectCustomer();
        // Build the HTTP response
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
