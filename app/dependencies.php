<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use Cake\Database\Connection;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        // Database connection
//        Connection::class => function (ContainerInterface $container) {
//            $settings = $container->get(SettingsInterface::class);
//            return new Connection($settings->get('db'));
//        },
//
//        PDO::class => function (ContainerInterface $container) {
//            $db = $container->get(Connection::class);
//            $driver = $db->getDriver();
//            $driver->connect();
//
//            return $driver->getConnection();
//        },
        PDO::class => function (ContainerInterface $c) {

//            $settings = $c->get(SettingsInterface::class);

            $dbSettings = [
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
            ];
            $dsn = "mysql:host=127.0.0.1;port=3357;dbname=Tunaiku_Loan;charset=utf8mb4";
            return new PDO($dsn, 'root', 'admin123');
        },

    ]);
};
