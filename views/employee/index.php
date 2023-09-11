<h2 class="second-primary">社員の登録</h2>
<form action="/employee/create" method="post">
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
