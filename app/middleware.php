<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $settings = $app->getContainer()->get('settings');
    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrors'],
        $settings['logErrorDetails']
    );
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
};
