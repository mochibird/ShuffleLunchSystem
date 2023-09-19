<?php

require_once(__DIR__ . '/vendor/autoload.php');

function dbConnect(): PDO
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();
    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];
    $dbSourceName = "mysql:host=$dbHost;dbname=$dbDatabase;charset=utf8mb4";
    try {
        $pdo = new PDO($dbSourceName, $dbUsername, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (PDOException $e) {
        echo 'DBエラー: ' . $e->getMessage();
        exit();
    }
    return $pdo;
}

function dropTableSql(PDO $pdo): void
{
    $stmt = $pdo->query('DROP TABLE IF EXISTS employees');
    if ($stmt) {
        echo 'テーブルの削除が完了しました。' . PHP_EOL;
    } else {
        echo 'テーブルの削除に失敗しました。' . PHP_EOL;
    }
}

function createTableSql(PDO $pdo): void
{
    $sql = <<<EOT
        CREATE TABLE employees(
            id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
            emp_no INTEGER,
            name VARCHAR(50),
            create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
EOT;
    $stmt = $pdo->query($sql);
    if ($stmt) {
        echo 'テーブルの作成が完了しました。' . PHP_EOL;
    } else {
        echo 'テーブルの作成に失敗しました。' . PHP_EOL;
    }
}

$pdo = dbConnect();
dropTableSql($pdo);
createTableSql($pdo);
$pdo = null;
