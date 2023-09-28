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
    
    /**
     * データベースマネージャを取得します。
     *
     * このメソッドは、現在のオブジェクトからデータベースマネージャオブジェクトを取得します。
     *
     * @return DatabaseManager データベースマネージャオブジェクト
     */
    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }
    
    /**
     * フレームワークのリクエスト処理を実行します。
     *
     * このメソッドは、リクエストを処理し、該当するコントローラーのアクションを呼び出します。
     * リクエストが見つからない場合は 404 エラーページを表示します。
     */
    public function run(): void
    {
        try {
            // リクエストのパス情報を解決し、該当するコントローラーとアクションを取得
            $params = $this->router->resolve($this->request->getPathInfo());
            
            if (!$params) {
                // パスが見つからない場合は HttpNotFoundException をスロー
                throw new HttpNotFoundException();
            }
            
            $controller = $params['controller'];
            $action = $params['action'];
            
            // 対応するコントローラーのアクションを実行
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
            // 404 エラーページを表示
            $this->render404Page();
        }
        
        // レスポンスを送信
        $this->response->send();
    }

    /**
     * アプリケーションのルーティングを定義します。
     *
     * このメソッドは、URL パスとそれに対応するコントローラーとアクションのマッピングを提供します。
     *
     * @return array ルーティング定義の配列
     */
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

    /**
     * 404 エラーページをレンダリングします。
     *
     * このメソッドは、HTTP 404 エラーが発生した際に表示されるエラーページを生成します。
     * レスポンスオブジェクトにステータスコードとコンテンツを設定します。
     */
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
