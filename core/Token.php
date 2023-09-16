<?php

class Token
{
    public static function createToken(): void
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    public static function validateToken(): void
    {
        if (empty($_SESSION['token']) ||
        $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
            throw new HttpNotFoundException();
        }
    }
}
