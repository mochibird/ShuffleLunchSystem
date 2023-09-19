<?php

class DatabaseModel
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    protected function fetchAll($sql): array
    {
        $result = $this->pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function execute(string $sql,  array $params):void
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt) {
                foreach ($params as $key => $value) {
                    $stmt->bindValue(':' . $key, $value);
                }
                $stmt->execute();
            } else {
                throw new PDOException('プリペアドステートメントの作成に失敗しました。');
            }
        } catch (PDOException $e) {
            echo 'エラー: ' . $e->getMessage();
        }
    }

    protected function update(string $sql, array $params): void
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt) {
                $stmt->execute($params);
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e){
            echo 'エラー: ' . $e->getMessage();
        }
    }
}
