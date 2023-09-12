<?php

$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
    throw new RuntimeException();
}

function dropTableSql($mysqli)
{
    $mysqli->query('DROP TABLE IF EXISTS employees');
}

function createTableSql($mysqli)
{
    $sql = <<<EOT
        CREATE TABLE employees(
            id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
            emp_no INTEGER NOT NULL,
            name VARCHAR(50) NOT NULL,
            create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
EOT;
    $mysqli->query($sql);
}

dropTableSql($mysqli);
createTableSql($mysqli);
$mysqli->close();
