<?php

namespace factories;
require_once 'Factory.php';

class PizzaPriceFactory extends Factory
{
    protected static function getTableName(): string
    {
        return 'pizza_prices';
    }

    public function fetchObjects($query)
    {
        $result = $this->connection->query($query);
        $objects = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $objects[] = (object) $row;
            }
        } else {
            echo "Ошибка выполнения запроса: " . $this->connection->error;
        }

        return $objects;
    }

    public function setAllPizzaPrices()
    {
        $pizzasQuery = 'SELECT * FROM pizzas;';
        $sizesQuery = 'SELECT * FROM sizes;';

        $pizzasObjects = $this->fetchObjects($pizzasQuery);
        $sizesObjects = $this->fetchObjects($sizesQuery);

        foreach ($pizzasObjects as $pizzaObject) {
            foreach ($sizesObjects as $sizeObject) {
                $price = 45; //todo
                $this->connection->query('INSERT INTO pizza_prices (pizza_id, size_id, price) VALUES (' . $pizzaObject->id . ',' . $sizeObject->id . ',' . $price . ');');
            }
        }
    }
}