-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2022 г., 09:01
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `author_id`, `name`, `text`, `created_at`) VALUES
(1, 1, 'Новое название статьи12', 'Новый текст статьи бла бла бла\r\n\r\n# Еще один новый текст\r\n# УРА УРА УРА\r\n\r\n```\r\nif ($good === \'not good\') {\r\n    echo \'NOT GOOD\';\r\n}\r\n```', '2022-03-06 01:34:04'),
(2, 1, 'Пост о жизни', 'Сидел я тут на кухне с друганом и тут он задал такой вопрос...', '2022-03-06 01:34:04'),
(3, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 00:58:55'),
(4, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:04:57'),
(5, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:09:37'),
(6, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:22:57'),
(7, 1, 'Новое название статьи поменять на новое', 'Новый текст статьи', '2022-03-07 01:23:50'),
(8, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:27:25'),
(9, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:28:14'),
(10, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:28:25'),
(11, 1, 'Новое название статьи', 'Новый текст статьи', '2022-03-07 01:29:47'),
(12, 11, 'Владимир', 'Создал новую статью для того чтобы сделать тест', '2022-03-10 23:29:03'),
(13, 1, 'Измененное название статьи в постмане', 'Текст статьи в постмане', '2022-03-20 05:57:47'),
(14, 1, 'Измененное название статьи в постмане', 'Текст статьи в постмане', '2022-03-20 05:58:20'),
(15, 1, 'Измененное название статьи в постмане', 'Текст статьи в постмане', '2022-03-20 05:58:46'),
(16, 1, 'Измененное название статьи в постмане', 'Текст статьи в постмане', '2022-03-20 05:59:33');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `article_id`, `text`) VALUES
(1, 12, 1, 'Очень интересное занятие мы увидели сейчас'),
(2, 12, 1, 'privet'),
(8, 11, 1, 'kak dela\r\n'),
(9, 11, 1, 'kak dela\r\n'),
(10, 11, 2, 'привет как дела\r\n'),
(11, 11, 4, 'руддщ\r\n'),
(12, 12, 5, 'fsdaf'),
(13, 11, 1, 'Я админ'),
(14, 11, 1, '13'),
(15, 11, 1, 'sdklfjsaldkjf'),
(16, 11, 1, 'jdsklfjs'),
(17, 11, 1, '3123123'),
(18, 11, 1, '12312'),
(19, 11, 1, 'привет'),
(20, 11, 1, 'привет'),
(21, 11, 1, 'привет'),
(22, 11, 1, 'рвплоырвао'),
(23, 11, 1, 'раолвыра'),
(24, 11, 1, 'ывафыва'),
(25, 11, 1, 'ывафыва'),
(26, 11, 1, '123'),
(27, 11, 1, '213124'),
(28, 11, 1, '12412'),
(29, 11, 7, '12345\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','user') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `is_confirmed`, `role`, `password_hash`, `auth_token`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 1, 'admin', 'hash1', 'token1', '2022-03-06 01:32:41'),
(2, 'user', 'user@gmail.com', 1, 'user', 'hash2', 'token2', '2022-03-06 01:32:42'),
(3, 'vladimir', '1602211@mail.ru', 0, 'user', '$2y$10$sOt25.iazweq9OzsAMyZ1uv8OOhKBi2GLulEh9btkcYGKWMdc2Doe', 'cffb806e930f20eefc944f3bb75ea9259369eda7fb8279e072752d64351a8b1ff14e20d50d4041a0', '2022-03-10 00:06:21'),
(4, 'vladimir2', '1602222@mail.ru', 0, 'user', '$2y$10$pK7VvuH34dXOIyISC63xseegLLPF2RY0SEB61gyLhUC1PKq370Ctm', 'daf3e3999874491a266e0c2848742be107f7cb251a92b5371eeeb5b97ea95e5c1221ae382ba6d4fc', '2022-03-10 00:09:26'),
(10, 'vladimir12', '1602211@gmail.com', 1, 'user', '$2y$10$Re2Y1BjKG6b5WDnmiaMP8e3fi5qlwGxNRz5VuWYs7j2MfXgEmqK1K', '84353737f01ca951ec0983ee2f89a1324b2f9478f8d94ddd9f161eed0b2dd0d676953ea91a4ae1b3', '2022-03-10 07:31:02'),
(11, 'vladimir111', '160221112@mail.ru', 1, 'admin', '$2y$10$FlfFZsaSzetH.LdhWxit5eO6LXIlXSXqBA5mz6hTSVY4E9pOTVzju', '242f47c569dbf50f40e9a0eab359d2518f379320373085c955b5ff062bc69e0670f85186b5cac252', '2022-03-10 20:20:00'),
(12, 'vladimir2222', '12345678@gmail.com', 1, 'user', '$2y$10$9Fj5/9b9JAgodN/g6lK3Pew0XLpMAB3Km1HZM2V1/9nOE9NA1WnP2', '510cf55d0b68559d618dcd91590b3e795284a419a744962df281de285a99a58d35ac7c71f983ef72', '2022-03-10 23:44:41');

-- --------------------------------------------------------

--
-- Структура таблицы `users_activation_codes`
--

CREATE TABLE `users_activation_codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
