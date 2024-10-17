<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amasty test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php

use Models\Pizza;
use Models\Size;
use Models\Sauce;

require_once 'db/models/Pizza.php';
require_once 'db/models/Size.php';
require_once 'db/models/Sauce.php';

require_once 'db/db.php';

$dbConfig = require 'db_config.php';
$db = new DatabaseConnection($dbConfig);

$pizzaModel = new Pizza($db);
$sizeModel = new Size($db);
$sauceModel = new Sauce($db);
$pizzas = $pizzaModel->get();
$sizes = $sizeModel->get();
$sauces = $sauceModel->get();
?>
<div class="orderPanel">
    <div>
        <select id="pizzaSelect">
            <?php
            foreach ($pizzas as $pizza) {
                echo '<option value="' . $pizza['id'] . '">' . $pizza['name'] . '</option>';
            }
            ?>
        </select>
        <select id="sizeSelect">
            <?php
            foreach ($sizes as $size) {
                echo '<option value="' . $size['id'] . '">' . $size['name'] . '</option>';
            }
            ?>
        </select>
        <select id="sauceSelect">
            <?php
            foreach ($sauces as $sauce) {
                echo '<option value="' . $sauce['id'] . '">' . $sauce['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <button class="button" id="orderButton">Заказать</button>
</div>
<div id="checkOut">
</div>
<script>
    $(document).ready(function() {
        $('#orderButton').click(function() {
            var pizzaId = $('#pizzaSelect').val();
            var sizeId = $('#sizeSelect').val();
            var sauceId = $('#sauceSelect').val();

            $.ajax({
                url: './controllers/OrderController.php',
                type: 'POST',
                data: {
                    method: 'placeOrder',
                    pizza_id: pizzaId,
                    size_id: sizeId,
                    sauce_id: sauceId
                },
                success: function(response) {
                    let numArray = response.split(',').map(String);
                    $('#checkOut').append("<div class='check'>Пицца " + numArray[0] + ", " + numArray[1] + " см, " + numArray[2] + " соус</div>");
                    let originalPrice = parseFloat(numArray[numArray.length - 1]); //цена в USD
                    $.ajax({
                        url: 'https://api.nbrb.by/exrates/rates/431',
                        type: 'GET',
                        success: function(rateResponse) {
                            let currentRate = rateResponse.Cur_OfficialRate;
                            let convertedPrice = (originalPrice * currentRate).toFixed(2); // цена в BYN
                            $('#checkOut').append("<div class='cost'> " + convertedPrice + " BYN" + "</div>");
                        },
                        error: function() {
                            $('#checkOut').append(originalPrice + ' USD');
                        }
                    });
                },
                error: function() {
                    $('#checkOut').html('Ошибка!!!');
                }
            });
        });
    });
</script>

</body>
</html>