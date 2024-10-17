<?php

namespace controllers;
use DatabaseConnection;

require_once __DIR__ . '/../db/db.php';
abstract class Controller
{
    protected DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }
}