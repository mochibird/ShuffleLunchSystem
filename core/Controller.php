<?php

class Controller
{
    protected $actionName;
    protected $request;
    protected $databaseManager;

    public function __construct($application)
    {
        $this->request = $application->getRequest();
        $this->databaseManager = $application->getDatabaseManager();
    }

    /**
     * 指定されたアクションを実行し、結果を文字列で返すメソッド
     *
     * @param string $action
     * @return string
     * @throws HttpNotFoundException
     */
    public function run(string $action): string
    {
        $this->actionName = $action;

        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }

        return $this->$action();
    }

    /**
     * ビューをレンダリングするメソッド
     *
     * @param array $variables
     * @param null $template
     * @param string $layout
     * @return string
     */
    protected function render(array $variables, $template = null, $layout = 'layout'): string
    {
        $view = new View(__DIR__ . '/../views');

        if (is_null($template)) {
            $template = $this->actionName;
        }

        $controllerName = strtolower(substr(get_class($this), 0, -10));
        $path = $controllerName . '/' . $template;

        return $view->render($path, $variables, $layout);
    }
}
