<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="昼食時間の社員のグループ分けを行うシステムです">
    <title>シャッフルランチサービス</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="primary">
            <a href="/">シャッフルランチ</a>
        </h1>
        <h2 class="employee_register_link">
            <a href="/employee">社員登録ページへ</a>
        </h2>
        <form action="/shuffle" method="post">
            <button class="btn" type="submit">シャッフルする</button>
        </form>
        <ul class="group_list">
            <?php foreach ($groups as $index => $group) : ?>
                <li class="group_item">
                    <div class="group_title">
                        ☆グループ<?php echo ($index + 1); ?>
                    </div>
                    <?php foreach ($group as $employee) : ?>
                        <div class="employee_name">
                            <p><?php echo $employee['name']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </li>
        </ul>
    </div>
</body>

</html>
