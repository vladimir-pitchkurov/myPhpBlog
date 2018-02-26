-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 26 2018 г., 08:18
-- Версия сервера: 5.6.38
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mytestdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `blog`
--

INSERT INTO `blog` (`id`, `user_id`, `author`, `title`, `text`, `date`) VALUES
(14, 9, 'Владимир пичкуров', 'Это пост обо всем', 'здесь можно все писать, даже то, что не решаешься сказать...   аххахах  ;)', '2018-02-25 20:23:59'),
(15, 11, 'Елена Кезля', 'Сортировка', 'Посты сортируются по времени. самые свежие вверху', '2018-02-26 05:12:11');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `embedded` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text_comment` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `embedded`, `author`, `text_comment`, `time`) VALUES
(65, 14, 9, 0, 'Владимир пичкуров', 'а это просто комментарий', '2018-02-25 20:24:19'),
(66, 14, 9, 0, 'Владимир пичкуров', 'комментарии можно редактировать или удалять, если вы их писали конечно, никто другой не может этого сделать)) кроме администратора БД', '2018-02-25 20:25:31'),
(67, 14, 9, 66, 'Владимир пичкуров', 'также комментарии могут быть вложенными, как того и требует ТЗ. на вложенные комментарии отвечать нельзя, можно продолжпть диалог в этой ветке., также их можно редактировать', '2018-02-25 20:34:51'),
(68, 15, 11, 0, 'Елена Кезля', 'комментарии также сортируются по времени', '2018-02-26 05:13:01'),
(69, 15, 11, 0, 'Елена Кезля', 'но комментарии - наоборот, самые свежие внизу', '2018-02-26 05:13:32'),
(70, 15, 11, 69, 'Елена Кезля', 'вложенные комментарии тоже сортируются', '2018-02-26 05:14:13'),
(71, 15, 11, 0, 'Елена Кезля', 'также стоит отметить, что при удалении поста, из базы удаляются все комментарии к нему', '2018-02-26 05:15:05');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `cookies` text NOT NULL,
  `picture` text NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `profile`, `cookies`, `picture`, `register_date`) VALUES
(9, 'Владимир пичкуров', 'vladimirpitbul@gmail.com', '115655905235129424624', 'ae884e64aa390560f99f45eaded24f98', 'https://lh6.googleusercontent.com/-uneY0v6HN7c/AAAAAAAAAAI/AAAAAAAAAHE/TztDPJXYGtw/photo.jpg', '2018-02-25 20:15:38'),
(11, 'Елена Кезля', 'myhappiness1979@gmail.com', '107215288216337619295', 'b2168ef90650f4bf928e19c486539fd3', 'https://lh4.googleusercontent.com/-2YykQYFUVz8/AAAAAAAAAAI/AAAAAAAAAEI/g06q5gjHNyk/photo.jpg', '2018-02-25 20:17:47');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blog`
--
ALTER TABLE `blog`
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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
