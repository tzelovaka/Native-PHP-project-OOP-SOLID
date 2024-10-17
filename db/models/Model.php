<?php

namespace models;

use DatabaseConnection;

require_once __DIR__ . '/../db.php';

abstract class Model
{
    protected DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    abstract protected static function getTableName(): string;
    abstract public function get(): array;
}