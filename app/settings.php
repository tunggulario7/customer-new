<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function (Container $container) {
    $container->set('settings', function() {
        return [
            'name' => 'Example Slim Application',
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
//            'db' => [
//                'driver' => \Cake\Database\Driver\Mysql::class,
//                'host' => '127.0.0.1',
//                'port' => 3357,
//                'database' => 'Tunaiku_Loan',
//                'username' => 'root',
//                'password' => 'admin123',
//                'encoding' => 'utf8mb4',
//                'collation' => 'utf8mb4_unicode_ci',
//                // Enable identifier quoting
//                'quoteIdentifiers' => true,
//                // Set to null to use MySQL servers timezone
//                'timezone' => null,
//                // PDO options
//                'flags' => [
//                    // Turn off persistent connections
//                    PDO::ATTR_PERSISTENT => false,
//                    // Enable exceptions
//                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                    // Emulate prepared statements
//                    PDO::ATTR_EMULATE_PREPARES => true,
//                    // Set default fetch mode to array
//                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                    // Set character set
//                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
//                ]
//            ]

            "db" => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => 3357,
                'database' => 'Tunaiku_Loan',
                'username' => 'root',
                'password' => 'admin123',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'flags' => [
                    // Turn off persistent connections
                    PDO::ATTR_PERSISTENT => false,
                    // Enable exceptions
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Emulate prepared statements
                    PDO::ATTR_EMULATE_PREPARES => true,
                    // Set default fetch mode to array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ],
            ],
        ];
    });
};
