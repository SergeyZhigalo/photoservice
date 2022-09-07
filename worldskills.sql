-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 29 2020 г., 23:26
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `worldskills`
--

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `hashtag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`id`, `owner_id`, `name`, `path`, `hashtag`) VALUES
(1, 1, 'Саванна ', '1.png', '#антилопы'),
(2, 1, 'Одуванчик', '2.png', '#лето'),
(3, 1, 'Эльбрус', '3.png', '#горы'),
(4, 2, 'Геометрия', '4.png', '#иллюзия'),
(5, 2, 'Озеро', '5.png', '#красота'),
(6, 2, 'Untitled', '6.png', '&nbsp;'),
(7, 3, 'Геометрия', '7.png', '#иллюзия'),
(8, 3, 'Альпийские горы', '8.png', '#альпы'),
(9, 3, 'Канада', '9.png', '&nbsp;'),
(10, 4, 'Попугай', '10.png', '#природа'),
(11, 4, 'Дорога', '11.png', '#природа'),
(12, 4, 'Закат', '12.png', '#природа'),
(13, 5, 'Россия', '13.png', '#природа'),
(14, 5, 'Маковое поле', '14.png', '#природа'),
(15, 5, 'Геометрия', '15.png', '&nbsp;');

-- --------------------------------------------------------

--
-- Структура таблицы `shared`
--

CREATE TABLE `shared` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `nameUser` varchar(255) NOT NULL,
  `surnameUser` varchar(255) NOT NULL,
  `phoneUser` varchar(255) NOT NULL,
  `komy` int(11) NOT NULL,
  `idPhoto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shared`
--

INSERT INTO `shared` (`id`, `idUser`, `nameUser`, `surnameUser`, `phoneUser`, `komy`, `idPhoto`) VALUES
(11, 1, 'Николай', 'Григорьевич', '81111111111', 2, 1),
(12, 1, 'Николай', 'Григорьевич', '81111111111', 3, 2),
(13, 1, 'Николай', 'Григорьевич', '81111111111', 4, 3),
(14, 1, 'Николай', 'Григорьевич', '81111111111', 5, 2),
(15, 2, 'Аркадий', 'Николаевич', '82222222222', 1, 4),
(16, 2, 'Аркадий', 'Николаевич', '82222222222', 3, 5),
(17, 2, 'Аркадий', 'Николаевич', '82222222222', 4, 6),
(18, 2, 'Аркадий', 'Николаевич', '82222222222', 5, 5),
(19, 3, 'Елена', 'Петровна', '83333333333', 1, 7),
(20, 3, 'Елена', 'Петровна', '83333333333', 2, 8),
(21, 3, 'Елена', 'Петровна', '83333333333', 4, 9),
(22, 3, 'Елена', 'Петровна', '83333333333', 5, 8),
(23, 4, 'Маргарита', 'Сергеевна', '84444444444', 1, 10),
(24, 4, 'Маргарита', 'Сергеевна', '84444444444', 2, 11),
(25, 4, 'Маргарита', 'Сергеевна', '84444444444', 3, 12),
(26, 4, 'Маргарита', 'Сергеевна', '84444444444', 5, 11),
(27, 5, 'Артем', 'Вячеславович', '85555555555', 1, 13),
(28, 5, 'Артем', 'Вячеславович', '85555555555', 2, 14),
(29, 5, 'Артем', 'Вячеславович', '85555555555', 3, 15),
(30, 5, 'Артем', 'Вячеславович', '85555555555', 4, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` double DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `phone`, `password`) VALUES
(1, 'Николай', 'Григорьевич', 81111111111, '1Aa!'),
(2, 'Аркадий', 'Николаевич', 82222222222, '1Aa!'),
(3, 'Елена', 'Петровна', 83333333333, '1Aa!'),
(4, 'Маргарита', 'Сергеевна', 84444444444, '1Aa!'),
(5, 'Артем', 'Вячеславович', 85555555555, '1Aa!');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shared`
--
ALTER TABLE `shared`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `shared`
--
ALTER TABLE `shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
