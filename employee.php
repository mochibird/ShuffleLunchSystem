<?php

function validateName(string $name): array
{
    $errors = [];
    if (!strlen($name)) {
        $errors['name'] = '社員名を入力してください。';
    } elseif (strlen($name) > 50) {
        $errors['name'] = '社員名を50文字以内で入力してください。';
    }
    return $errors;
}

$errors = [];
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
    throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
}
$result = $mysqli->query('SELECT name FROM employees');
$employees = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateName($_POST['name']);
    if (!count($errors)) {
        $stmt = $mysqli->prepare('INSERT INTO employees(name) VALUES (?)');
        if ($stmt) {
            $stmt->bind_param('s', $_POST['name']);
        }
        $stmt->execute();
        $stmt->close();
        header('Location: employee.php');
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="シャッフルランチサービスの社員登録画面">
    <title>シャッフルランチサービス 社員登録画面</title>
</head>

<body>
    <div class="container">
        <h1 class="primary">
            <a href="/">シャッフルランチ</a>
        </h1>
        <h2 class="second-primary">社員の登録</h2>
        <form action="/" method="post">
            <label for="name">社員名</label>
            <input type="text" name="name" id="name">
            <button type="submit">登録する</button>
        </form>
        <h2 class="second-primary">社員の一覧</h2>
        <ul>
            <?php foreach ($employees as $employee) : ?>
                <li>
                    <div class="employee_name">
                        <p><?php echo $employee['name']; ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>
