<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private PDO $connection;

    private PDOStatement $stmt;

    public function __construct(string $driver, array $config, string $username, string $password)
    {
        $config = http_build_query(data: $config, arg_separator: ";");
        $dsn = "{$driver}:{$config}";
        try {
            $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (PDOException $e) {
            die("Unable to connect Database");
        }
    }
    public function query(string $query, array $params = []): Database
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);

        return $this;
    }
    public function find()
    {
        return $this->stmt->fetch();
    }
    public function find_all()
    {
        return $this->stmt->fetchAll();
    }
    public function count()
    {
        return $this->stmt->fetchColumn();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    } //getting last registered id
    public function
    fetchColumn()
    {
        return $this->stmt->fetchColumn();
    } //getting last registered id
    public function
    row_count()
    {
        return $this->stmt->rowCount();
    } //getting last registered id

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }
    public function endTransaction()
    {
        $this->connection->commit();
    }



    public function cancelTransaction()
    {
        $this->connection->rollBack();
    }
}
