<?php

require_once(__DIR__ . '/core/Router.php');
require_once(__DIR__ . '/controller/ShuffleController.php');
require_once(__DIR__ . '/controller/EmployeeController.php');
class Application
{
    private $router;

    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
    }

    public function run()
    {
        $params = $this->router->resolve($this->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
    }

    public function runAction(string $controller, string $action)
    {
        $controllerName = ucfirst($controller) . 'Controller';
        $controllerClass = new $controllerName();
        $controllerClass->run($action);
    }

    public function registerRoutes(): array
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create'],
        ];
    }

    public function getPathInfo(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

}
