<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="昼食時間の社員のグループ分けを行うサービスです">
    <title><?php if (isset($title)) : echo $title;
            endif; ?>シャッフルランチサービス</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheets/css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="primary">
            <a href="/">シャッフルランチ</a>
        </h1>
        <?php echo $content; ?>
    </div>
</body>

</html>
