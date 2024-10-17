<?php

namespace models;

require_once 'Model.php';

class Pizza extends Model
{
    protected static function getTableName(): string
    {
        return 'pizzas';
    }

    public function get(): array
    {
        $sql = 'SELECT * FROM ' . self::getTableName();
        $result = $this->connection->query($sql);

        if ($result === false) {
            return [];
        }

        $pizzas = [];
        while ($row = $result->fetch_assoc()) {
            $pizzas[] = $row;
        }

        return $pizzas;
    }
}