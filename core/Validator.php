<?php

trait Validator
{
    public function validateEmployeeInsertData(array $params, array $employeesData): array
    {
        $errors = [];
        $errors['name'] = $this->validateName($params['name']);
        $errors['number'] = $this->validateNumber($params['number'], $employeesData);
        return $errors;
    }

    public function validateNumber(string $empNum, array $employeesData): string
    {
        $error = '';
        if (!strlen($empNum)) {
            $error = '従業員番号を入力してください。';
        } elseif(!preg_match("/^\d+$/", $empNum)) {
            $error = '従業員番号を半角数字で入力してください。';
        }
        $existingEmpNos = [];
        foreach ($employeesData as $employee) {
            $existingEmpNos[] = $employee['emp_no'];
        }
        if (in_array((int)$empNum, $existingEmpNos)) {
            $error = 'すでに登録されている従業員番号は登録することができません。';
        }
        return $error;
    }

    public function validateName(string $name): string
    {
        $error = '';
        if (!strlen($name)) {
            $error = '社員名を入力してください。';
        } elseif (strlen($name) > 50) {
            $error = '社員名を50文字以内で入力してください。';
        }
        return $error;
    }
}
