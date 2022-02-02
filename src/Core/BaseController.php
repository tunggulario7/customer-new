<?php
namespace App\Core;

use App\Repository\CustomerRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    protected $view;
    protected $logger;
    protected $flash;
    protected $em;  // Entities Manager
    protected CustomerRepository $repository;

    public function __construct(ContainerInterface $container, CustomerRepository $repository)
    {
        $this->view = $container->get('view');
        $this->logger = $container->get('logger');
        $this->flash = $container->get('flash');
        $this->em = $container->get('em');
        $this->repository = $repository;
    }

    protected function render(Request $request, Response $response, string $template, array $params = []): Response
    {
        $params['flash'] = $this->flash->getMessage('info');
        $params['uinfo'] = $request->getAttribute('uinfo');

        return $this->view->render($response, $template, $params);
    }
}