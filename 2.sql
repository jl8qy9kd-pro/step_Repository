-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 15 2021 г., 16:16
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_samson`
--

-- --------------------------------------------------------

--
-- Структура таблицы `a_category`
--

CREATE TABLE `a_category` (
  `ид_категории` int(11) NOT NULL,
  `код_категории` varchar(255) DEFAULT NULL,
  `название` varchar(255) DEFAULT NULL,
  `ид_родителя` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_price`
--

CREATE TABLE `a_price` (
  `ид_продукта` int(11) NOT NULL,
  `тип` varchar(255) DEFAULT NULL,
  `цена` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_product`
--

CREATE TABLE `a_product` (
  `ид_продукта` int(11) NOT NULL,
  `код_продукта` varchar(255) DEFAULT NULL,
  `название` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_property`
--

CREATE TABLE `a_property` (
  `ид_продукта` int(11) NOT NULL,
  `название` varchar(255) DEFAULT NULL,
  `свойство` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `combiconnect`
--

CREATE TABLE `combiconnect` (
  `ид_продукта` int(11) NOT NULL,
  `ид_категории` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `a_category`
--
ALTER TABLE `a_category`
  ADD PRIMARY KEY (`ид_категории`);

--
-- Индексы таблицы `a_product`
--
ALTER TABLE `a_product`
  ADD PRIMARY KEY (`ид_продукта`);

--
-- Индексы таблицы `combiconnect`
--
ALTER TABLE `combiconnect`
  ADD PRIMARY KEY (`ид_продукта`,`ид_категории`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `a_category`
--
ALTER TABLE `a_category`
  MODIFY `ид_категории` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `a_product`
--
ALTER TABLE `a_product`
  MODIFY `ид_продукта` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
