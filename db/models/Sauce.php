<?php

namespace Models;

require_once 'Model.php';

class Sauce extends Model
{
    protected static function getTableName(): string
    {
        return 'sauces';
    }

    public function get(): array
    {
        $sql = 'SELECT * FROM ' . self::getTableName();
        $result = $this->connection->query($sql);

        if ($result === false) {
            return [];
        }

        $sauces = [];
        while ($row = $result->fetch_assoc()) {
            $sauces[] = $row;
        }

        return $sauces;
    }
}