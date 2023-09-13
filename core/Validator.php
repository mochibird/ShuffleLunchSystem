<?php

trait Validator
{
    public function validateEmployeeInsertData(array $params, array $employeesData): array
    {
        $errors = [];
        $errors['name'] = $this->validateInsertName($params['name']);
        $errors['number'] = $this->validateInsertNumber($params['number'], $employeesData);
        return $errors;
    }

    public function validateEmployeeUpdateData(array $params, array $employeesData): array
    {
        $errors = [];
        $errors['name'] = $this->validateUpdateName($params['name'], $params['number'], $employeesData);
        $errors['number'] = $this->validateUpdateNumber($params['number'], $employeesData);
        return $errors;
    }

    public function validateUpdateName(string $name, string $empNum, array $employeesData): string
    {
        $error = '';
        if (!strlen($name)) {
            $error = '社員名を入力してください。';
        } elseif (strlen($name) > 50) {
            $error = '社員名を50文字以内で入力してください。';
        }

        foreach ($employeesData as $employee) {
            if ($employee['emp_no'] === (int)$empNum &&
                $employee['name'] === $name) {
                $error = '新しい社員名を入力してください。';
                break;
            }
        }
        return $error;
    }

    public function validateUpdateNumber(string $empNum, array $employeesData): string
    {
        $error = '';
        if (!strlen($empNum)) {
            $error = '従業員番号を入力してください。';
        } elseif (!preg_match('/^[0-9]+$/', $empNum)) {
            $error = '従業員番号を半角数字で入力してください。';
        } elseif ($empNum > 1000) {
            $error = '従業員番号を1000以下の半角数字で入力してください。';
        } elseif (!$this->isOrderEmpNumData($empNum, $employeesData)) {
            $error = '登録されていない社員番号を入力しています';
        }
        return $error;
    }

    public function validateInsertNumber(string $empNum, array $employeesData): string
    {
        $error = '';
        if (!strlen($empNum)) {
            $error = '従業員番号を入力してください。';
        } elseif(!preg_match("/^\d+$/", $empNum)) {
            $error = '従業員番号を半角数字で入力してください。';
        } elseif ($empNum > 1000) {
            $error = '従業員番号を1000以下の半角数字で入力してください。';
        } elseif ($this->isOrderEmpNumData($empNum, $employeesData)) {
            $error = 'すでに登録されている従業員番号は登録することができません。';
        }
        return $error;
    }

    public function validateInsertName(string $name): string
    {
        $error = '';
        if (!strlen($name)) {
            $error = '社員名を入力してください。';
        } elseif (strlen($name) > 50) {
            $error = '社員名を50文字以内で入力してください。';
        }
        return $error;
    }

    private function isOrderEmpNumData(string $empNum, array $employeesData): bool
    {
        $existingEmpNos = [];
        foreach ($employeesData as $employee) {
            $existingEmpNos[] = $employee['emp_no'];
        }
        if (in_array($empNum, $existingEmpNos)) {
            return true;
        }
        return false;
    }
}
