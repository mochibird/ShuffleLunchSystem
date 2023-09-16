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
        $dbh = new PDO($dbSourceName, $dbUsername, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (PDOException $e) {
        echo 'DBエラー: ' . $e->getMessage();
        exit();
    }
    return $dbh;
}

function dropTableSql(PDO $dbh)
{
    $dbh->query('DROP TABLE IF EXISTS employees');
}

function createTableSql(PDO $dbh)
{
    $sql = <<<EOT
        CREATE TABLE employees(
            id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
            emp_no INTEGER,
            name VARCHAR(50),
            create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
EOT;
    $dbh->query($sql);
}

$dbh = dbConnect();
dropTableSql($dbh);
createTableSql($dbh);
$dbh = null;
