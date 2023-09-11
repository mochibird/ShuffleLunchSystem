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
