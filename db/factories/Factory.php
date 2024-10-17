<?php

namespace factories;

use DatabaseConnection;

require_once __DIR__ . '/../db.php';

abstract class Factory
{
    protected DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    abstract protected static function getTableName(): string;
}