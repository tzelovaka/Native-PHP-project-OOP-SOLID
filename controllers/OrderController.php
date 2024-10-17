<?php

namespace controllers;
use DatabaseConnection;

$dbConfig = require_once __DIR__ . '/../db_config.php';
require_once ('Controller.php');
class OrderController extends Controller {

    public function placeOrder($pizzaId, $sizeId, $sauceId) {
        $pizzaPrice = $this->connection->prepareAndExecute(
            'SELECT price FROM pizza_prices WHERE pizza_id = ? AND size_id = ?;',
            'ii', $pizzaId, $sizeId
        )->fetch_assoc()["price"];
        $saucePrice = $this->connection->prepareAndExecute(
            'SELECT price FROM sauces WHERE id = ?',
            'i', $sauceId
        )->fetch_assoc()["price"];
        $cost = $pizzaPrice + $saucePrice;
        $sql = 'INSERT INTO orders (pizza_id, size_id, sauce_id, cost) VALUES (?, ?, ?, ?)';
        $result = $this->connection->prepareAndExecute($sql, 'iiii', $pizzaId, $sizeId, $sauceId, $cost);
        return $result;
    }

    public function handleRequest() {
        if (isset($_POST['method'])) {
            $method = $_POST['method'];
            switch ($method) {
                case 'placeOrder':
                    $pizzaId = $_POST['pizza_id'];
                    $sizeId = $_POST['size_id'];
                    $sauceId = $_POST['sauce_id'];

                    $result = $this->placeOrder($pizzaId, $sizeId, $sauceId);

                    if ($result) {
                        $pizzaPrice = $this->connection->prepareAndExecute(
                            'SELECT price FROM pizza_prices WHERE pizza_id = ? AND size_id = ?;',
                            'ii', $pizzaId, $sizeId
                        )->fetch_assoc()["price"];

                        $pizza = $this->connection->prepareAndExecute(
                            'SELECT name FROM pizzas WHERE id = ?',
                            'i', $pizzaId
                        )->fetch_assoc()["name"];

                        $size = $this->connection->prepareAndExecute(
                            'SELECT name FROM sizes WHERE id = ?',
                            'i', $sizeId
                        )->fetch_assoc()["name"];

                        $sauce = $this->connection->prepareAndExecute(
                            'SELECT name FROM sauces WHERE id = ?',
                            'i', $sauceId
                        )->fetch_assoc()["name"];

                        $saucePrice = $this->connection->prepareAndExecute(
                            'SELECT price FROM sauces WHERE id = ?',
                            'i', $sauceId
                        )->fetch_assoc()["price"];
                        echo $pizza . ', ' . $size . ', ' . $sauce . ', ' . ($pizzaPrice + $saucePrice);
                    } else {
                        echo 'ОШИБКА';
                    }
                    break;
                default:
                    echo json_encode(['status' => 'invalid_method']);
                    break;
            }
        } else {
            echo json_encode(['status' => 'no_method']);
        }
    }
}

$db = new DatabaseConnection($dbConfig);
$controller = new OrderController($db);
$controller->handleRequest();