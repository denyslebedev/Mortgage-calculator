-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 26 2022 г., 22:43
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `nov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banks`
--

CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL,
  `bank_name` text NOT NULL,
  `interest_rate` float NOT NULL,
  `max_loan` int(11) NOT NULL,
  `min_pay` int(11) NOT NULL,
  `loan_term` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `interest_rate`, `max_loan`, `min_pay`, `loan_term`) VALUES
(1, 'Bank of New York', 3, 200000, 10, 36),
(2, 'PrivatBank', 20, 300000, 20, 36),
(3, 'Credit Agrecole', 4, 250000, 15, 24),
(4, 'PUMB', 6, 500000, 10, 36);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `activecode` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` varchar(256) NOT NULL,
  `prepre` varchar(255) NOT NULL,
  `pre` varchar(255) NOT NULL,
  `current` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `status`, `activecode`, `timestamp`, `type`, `prepre`, `pre`, `current`) VALUES
(10, 'Ups', 'nov', 'ups@gmail.com', '2710', 1, 312133789, 1525377438, 'user', '100000', '20000', '4'),
(11, 'Test', 'Test', 'change.change@gmail.com', '271096', 1, 725646972, 1525377670, 'user', '13567', '15789', '0'),
(12, 'Test1', 'Test1', 'test1.test1@gmail.com', '2710', 1, 293579101, 1525377681, 'user', '13000', '15000', '17000'),
(13, 'Denys', 'Lebedev', 'admin@admin.ua', '2710', 1, 867980957, 1650977162, 'master', '100000', '10000', '4'),
(14, 'test', 'test1', 'test@test.ua', '2710', 1, 646789550, 1651002113, 'user', '100000', '20000', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
