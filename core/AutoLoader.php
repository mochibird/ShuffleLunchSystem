<?php

class AutoLoader
{
    private $dirs;

    public function register(): void
    {
        spl_autoload_register([$this, 'classLoad']);
    }

    public function registerDir(string $dir): void
    {
        $this->dirs[] = $dir;
    }

    private function classLoad($className): void
    {
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $className . '.php';
            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
}
