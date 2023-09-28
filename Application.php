<?php

require_once(__DIR__ . '/vendor/autoload.php');

class Application
{
    private $router;
    private $response;
    private $request;
    private $databaseManager;
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
        $dotenv->load();
        $dbHost = $_ENV['DB_HOST'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $dbSourceName = "mysql:host=$dbHost;dbname=$dbDatabase;charset=utf8mb4";
        $this->router = new Router($this->registerRoutes());
        $this->response = new Response();
        $this->request = new Request();
        $this->databaseManager = new DatabaseManager();
        $this->databaseManager->connect([
            'hostname' => $dbHost,
            'username' => $dbUsername,
            'password' => $dbPassword,
            'database' => $dbDatabase,
            'dbSource' => $dbSourceName,
        ]);
    }

    /**
     * 現在のオブジェクトからリクエストオブジェクトを取得します。
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }

    public function run(): void
    {
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
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
        $controllerClass = new $controllerName($this);
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
            '/employee/edit' => ['controller' => 'employee', 'action' => 'edit'],
            '/employee/edit/update' => ['controller' => 'employee', 'action' => 'update'],
        ];
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
