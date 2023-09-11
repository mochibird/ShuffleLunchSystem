<?php

trait Validator
{
    public function validateName(string $name): array
    {
        $errors = [];
        if (!strlen($name)) {
            $errors['name'] = '社員名を入力してください。';
        } elseif (strlen($name) > 50) {
            $errors['name'] = '社員名を50文字以内で入力してください。';
        }
        return $errors;
    }
}
