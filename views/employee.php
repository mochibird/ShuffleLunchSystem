<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="シャッフルランチサービスの社員登録画面">
    <title>シャッフルランチサービス 社員登録画面</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="primary">
            <a href="/">シャッフルランチ</a>
        </h1>
        <h2 class="second-primary">社員の登録</h2>
        <form action="/employee.php" method="post">
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
