<?php

namespace Models;

require_once 'Model.php';

class Size extends Model
{
    protected static function getTableName(): string
    {
        return 'sizes';
    }

    public function get(): array
    {
        $sql = 'SELECT * FROM ' . self::getTableName();
        $result = $this->connection->query($sql);

        if ($result === false) {
            return [];
        }

        $sizes = [];
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row;
        }

        return $sizes;
    }
}