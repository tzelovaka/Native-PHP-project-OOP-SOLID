-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 17 2024 г., 23:30
-- Версия сервера: 8.0.39
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `amasty_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `pizza_id` int UNSIGNED NOT NULL,
  `size_id` int UNSIGNED NOT NULL,
  `sauce_id` int UNSIGNED NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pizzas`
--

CREATE TABLE `pizzas` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `pizzas`
--

INSERT INTO `pizzas` (`id`, `name`) VALUES
(3, 'Гавайская'),
(4, 'Грибная'),
(2, 'Деревенская'),
(1, 'Пепперони');

-- --------------------------------------------------------

--
-- Структура таблицы `pizza_prices`
--

CREATE TABLE `pizza_prices` (
  `id` int NOT NULL,
  `pizza_id` int UNSIGNED NOT NULL,
  `size_id` int UNSIGNED NOT NULL,
  `price` float NOT NULL DEFAULT '23'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `pizza_prices`
--

INSERT INTO `pizza_prices` (`id`, `pizza_id`, `size_id`, `price`) VALUES
(5, 3, 1, 18),
(6, 3, 2, 25),
(7, 3, 3, 30),
(8, 3, 4, 40),
(9, 4, 1, 22),
(10, 4, 2, 31),
(11, 4, 3, 39),
(12, 4, 4, 45),
(13, 2, 1, 20),
(14, 2, 2, 26),
(15, 2, 3, 32),
(16, 2, 4, 45),
(17, 1, 1, 22),
(18, 1, 2, 28),
(19, 1, 3, 35),
(20, 1, 4, 50);

-- --------------------------------------------------------

--
-- Структура таблицы `sauces`
--

CREATE TABLE `sauces` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `sauces`
--

INSERT INTO `sauces` (`id`, `name`, `price`) VALUES
(1, 'сырный', 2),
(2, 'кисло-сладкий', 2),
(3, 'чесночный', 2),
(4, 'барбекю', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id` int UNSIGNED NOT NULL,
  `name` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, 21),
(2, 26),
(3, 31),
(4, 45);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pizza_id` (`pizza_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `sauce_id` (`sauce_id`);

--
-- Индексы таблицы `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `pizza_prices`
--
ALTER TABLE `pizza_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pizza_id` (`pizza_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Индексы таблицы `sauces`
--
ALTER TABLE `sauces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT для таблицы `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `pizza_prices`
--
ALTER TABLE `pizza_prices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `sauces`
--
ALTER TABLE `sauces`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`sauce_id`) REFERENCES `sauces` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `pizza_prices`
--
ALTER TABLE `pizza_prices`
  ADD CONSTRAINT `pizza_prices_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pizza_prices_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
