<a href="/employee/edit">登録情報の編集</a>
<h2 class="second-primary">○社員の登録</h2>
<?php if (count($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
        <div>
            <p><?php echo $error; ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<form action="/employee/create" method="post">
    <div class="group-form">
        <label class="group-label" for="number">社員番号</label>
        <input type="number" name="number" id="number">
    </div>
    <div class="group-form">
        <label class="group-label" for="name">社員名</label>
        <input type="text" name="name" id="name">
    </div>
    <input type="hidden" name="token" value="<?php echo Utils::escapeString($_SESSION['token']); ?>">
    <button class="btn" type="submit">登録する</button>
</form>
<h2 class="second-primary">○社員の一覧</h2>
<ul class="employee_list">
    <?php foreach ($employees as $employee) : ?>
        <li class="employee_item">
            <div>
                <p>社員番号 : <?php echo Utils::escapeString($employee['emp_no']); ?></p>
            </div>
            <div class="employee_name">
                <p>社員名 : <?php echo Utils::escapeString($employee['name']); ?></p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
