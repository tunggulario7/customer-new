<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
//    $app->options('/{routes:.*}', function (Request $request, Response $response) {
//        // CORS Pre-Flight OPTIONS Request Handler
//        return $response;
//    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world guys!');
        return $response;
    });

//    $app->group('/users', function (Group $group) {
//        $group->get('', ListUsersAction::class);
//        $group->get('/{id}', ViewUserAction::class);
//    });

    $app->group('/customer', function (Group $group) {
        $group->post('', 'App\Controllers\CustomerController::send')->setName('send');
    });
//    $app->post('/customer', function (Request $request, Response $response, array $args) {
//        $response->getBody()->write(json_encode($request->getParsedBody()));
//        return $response;
//    });

//    $app->group('/member', function (Group $group) {
//        $group->map(['GET', 'POST'],'/login', 'App\Controller\AuthController:login')->setName('login');
//        $group->get('/logout', 'App\Controller\AuthController:logout')->setName('logout');
//
//    });
};
