<?php

namespace App\Models;

use \PDO;

class Connection
{
    private $host = '127.0.0.1';
    private $port = 3357;
    private $user = 'root';
    private $pass = 'admin123';
    private $dbname = 'Tunaiku_Loan';


    public function connect()
    {
//        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn_str = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8mb4";
//        var_dump($conn_str);
        $conn = new \PDO($conn_str, $this->user, $this->pass);
//        var_dump($conn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}