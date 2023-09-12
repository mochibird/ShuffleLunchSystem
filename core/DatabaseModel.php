<?php

class DatabaseModel
{
    protected $mysqli;
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function fetchAll($sql): array
    {
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function execute(string $sql, array $params): void
    {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(...$params);
        }
        $stmt->execute();
        $stmt->close();
    }
}
