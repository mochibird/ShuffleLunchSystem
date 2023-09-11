<?php

class Controller
{
    protected $actionName;
    protected $application;
    public function __construct($application)
    {
        $this->application = $application;
    }

    public function run(string $action): string
    {
        $this->actionName = $action;
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }
        return $this->$action();
    }

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
