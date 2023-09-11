<?php

class Application
{
    private $router;
    private $response;

    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
        $this->response = new Response();
    }

    public function run(): void
    {
        try {
            $params = $this->router->resolve($this->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundException();
            }
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
                $this->render404Page();
        }
        $this->response->send();
    }

    public function runAction(string $controller, string $action): void
    {
        $controllerName = ucfirst($controller) . 'Controller';
        if (!class_exists($controllerName)) {
            throw new HttpNotFoundException();
        }
        $controllerClass = new $controllerName();
        $content = $controllerClass->run($action);
        $this->response->setContent($content);
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

    public function render404Page(): void
    {
        $this->response->setStatusCode('404', 'Not Found');
        $this->response->setContent(
<<<EOF
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="昼食時間の社員のグループ分けを行うシステムです">
    <title>Error 404</title>
</head>

<body>
    <div class="container">
        <h1 class="primary">
            Not Found Page
        </h1>
    </div>
</body>

</html>
EOF
        );
    }
}
