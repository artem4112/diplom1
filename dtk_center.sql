-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 17 2026 г., 01:44
-- Версия сервера: 5.6.51
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dtk_center`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `genre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `language` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `writer_id`, `title`, `year`, `genre`, `language`, `description`, `sort_order`) VALUES
(1, 1, '«Кто построил этот дом»', '1950', 'Сборник стихов для детей', 'Русский', 'Первая книга автора, рассказывающая малышам о труде строителей и разных профессиях.', 1),
(2, 1, '«Про Светлану»', '1951', 'Сборник детских рассказов', 'Русский', 'Цикл коротких и добрых историй о повседневной жизни, взрослении и простых радостях маленькой девочки.', 2),
(3, 1, '«Шаг за шагом»', '1956', 'Детская повесть в стихах', 'Русский', 'Книга о жизни советских школьников, их учебе, дружбе, первых обязанностях и правилах поведения.', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_option` tinyint(4) NOT NULL COMMENT '0 - A, 1 - B, 2 - C',
  `hint` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question_text`, `option_a`, `option_b`, `option_c`, `correct_option`, `hint`) VALUES
(16, 7, 'В каком городе родился писатель Сергей Алексеевич Баруздин?', 'в Ленинграде', 'в Москве', 'в Сталинграде', 1, ''),
(17, 7, 'В каком детском журнале напечатали его первые рассказы?', '«Затейники»', '«Пионер»', '«Дружба народов»', 1, ''),
(18, 7, 'Сколько лет прибавил будущий писатель, чтобы попасть на фронт?', '1', '2', '3', 1, ''),
(19, 7, 'Что за животные Рави и Шаши?', 'мангусты', 'медвежата', 'слонята', 2, ''),
(20, 7, 'Как переводятся на русский язык их имена — Рави и Шаши?', 'Солнце и Луна', 'Трава и Цветок', 'День и Ночь', 0, ''),
(21, 7, 'На чем поплыли слонята Рави и Шаши к советским детям?', 'на корабле', 'на теплоходе', 'на катамаране', 1, ''),
(22, 7, 'Увидев кого, макаки молниеносно взлетали на самые верхушки мачт?', 'слонов', 'моряков', 'удавов', 2, ''),
(23, 7, 'От чего Шаши заболела?', 'от ночного холода', 'от сильной качки', 'от порции еды', 1, ''),
(24, 7, 'Сколько суток плыли Рави и Шаши на теплоходе «Ставрополь»?', '16', '17', '18', 0, ''),
(25, 7, 'Сколько лет было новой соседке — слонихе Дели?', '8', '9', '10', 2, ''),
(26, 8, 'По образованию Виктория Ледерман', 'филолог и педагог', 'детский библиотекарь', 'журналист', 0, ''),
(27, 8, 'Сколько лет было Виктории, когда она написала свой первый рассказ?', '9 лет', '10 лет', '11 лет', 0, ''),
(28, 8, 'Какое произведение принесло Виктории Ледерман специальный приз премии им. В.П. Крапивина в 2014 году?', '«Уроков не будет!»', '«Всего одиннадцать! или Шуры-муры в пятом „Д“»', '«Календарь ма(й)я»', 2, ''),
(29, 8, 'Сколько лет главному герою повести «Теория невероятностей» Матвею Добровольскому?', '12', '13', '14', 1, ''),
(30, 8, 'Как Матвей относился к посещению школьных мероприятий?', 'активно участвовал в них', 'злился, но всё-таки посещал их', 'стойко их игнорировал', 2, ''),
(31, 8, 'Много ли друзей было у Матвея?', 'ни одного', 'несколько одноклассников', 'один лучший друг', 0, ''),
(32, 8, 'Каким образом Матвей попал в параллельный мир?', 'спрятавшись в заброшенной бетонной трубе', 'через виртуальную сеть', 'потерявшись в лесу', 0, ''),
(33, 8, 'Как звали девочку из альтернативной вселенной?', 'Владислава', 'Милослава', 'Ярослава', 1, ''),
(34, 8, 'Что постоянно слушал Веня Ватрушкин в наушниках?', 'фантастический роман о параллельных реальностях', 'лекции по астрономии', 'рассказы о «Майнкрафт»', 0, ''),
(35, 8, 'С чьей помощью Матвею удалось вернуться в свою реальность?', 'с помощью учёных', 'с помощью родителей', 'с помощью одноклассника', 2, ''),
(36, 9, 'Что означает имя Мария-Нулгынэт в переводе с эвенского?', '«Рождённая во время кочёвки»', '«Рождённая во время пурги»', '«Рождённая на оленьей упряжке»', 0, ''),
(37, 9, 'В каком году вышла первая книга писательницы?', '1995 «Тэбэнэттээх Нулгынэт»', '2000 «Оленёнок, который ищет молоко»', '2015 «Шалунья Нулгынэт»', 0, ''),
(38, 9, 'Какой кружок организовала Мария Прокопьевна Федотова в школе?', 'литературный', 'домоводства', 'шахматный', 0, ''),
(39, 9, 'Любимая игрушка маленькой Нулгынэт', 'деревянные игрушки', 'камешки', 'куклы', 1, ''),
(40, 9, 'Кличка собаки из повести «Игра в камешки», которая вытащила Нулгынэт из воды', 'Пенка', 'Утикан', 'Омни', 0, ''),
(41, 9, 'Чьи это слова: «Страхом ещё никто никого ничему хорошему не научил»?', 'мамы — Христины Петровны', 'дедушки — Николая Христофоровича', 'учительницы — Любови Ивановны', 0, ''),
(42, 9, 'Имя собаки из повести «Игра в камешки», которая приносила зайцев и спасла хозяев от голода', 'Мухала', 'Пенка', 'Мойтурук', 0, ''),
(43, 9, 'Назовите хорошее прозвище Нулгынэт', 'Солнышко', 'Яблоко', 'Малышка', 1, ''),
(44, 9, 'Какую раненую птицу вылечил мама Нулгынэт?', 'орла', 'чёрного аиста', 'филина', 0, ''),
(45, 9, 'Чьи это слова: «Вот я настоящего черта видел… У него один глаз, одна рука, одна нога, рот большой, а сам чёрный-пречерный...»?', 'пастуха Никуса', 'русского геолога', 'пастуха Ванчика', 2, ''),
(46, 10, 'С кем Сэмэнчик отправился домой на каникулы?', 'с другом Гришей Романовым', 'с другом Ваней Ачикасовым', 'с отцом вдвоём', 0, ''),
(47, 10, 'Как охотятся на тюленей?', 'стреляют из ружья', 'ставят капканы', 'ставят в водоёме верши (туу)', 0, ''),
(48, 10, 'Чем угощают гостя на Севере после дальней поездки?', 'горячим чаем', 'блинами', 'строганиной', 2, ''),
(49, 10, 'Какой транспорт считается самым лучшим на Севере?', 'олень', 'лошадь', 'собака', 0, ''),
(50, 10, 'Как называется меховое пальто?', 'тулуп', 'доха', 'сукуй', 2, ''),
(51, 10, 'Какое народное правило сбора гусиных яиц?', 'в гнезде оставляют 1 яйцо', 'оставляют 2-3 яйца', 'забирают все до единого', 0, ''),
(52, 10, 'За что отец наказал Сэмэнчика?', 'за драку с другом', 'собрал все яйца из гнезда', 'на охоту не ходил', 1, ''),
(53, 10, 'Сколько дней блуждал отец Сэмэнчика в тундре?', '3 дня', '4 дня', '6 дней', 1, ''),
(54, 10, 'Что Сэмэнчик называет «снайперским» атрибутом для игры?', 'кость мамонта', 'клык молодого моржа', 'рога оленя', 1, ''),
(55, 10, 'На какое время друг Гриша Романов приехал к Сэмэнчику?', 'на неделю', 'на 1 месяц', 'на всё лето', 2, '');

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sort_order` int(11) DEFAULT '0',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`id`, `title`, `description`, `created_at`, `updated_at`, `sort_order`, `image_path`) VALUES
(7, 'Сергей Баруздин: жизнь и творчество', 'Тест по биографии и произведениям С.А. Баруздина, в том числе по повести «Рави и Шаши»', '2026-06-01 10:46:59', '2026-06-04 13:06:37', 1, NULL),
(8, 'Виктория Ледерман: «Теория невероятностей»', 'Тест по биографии писательницы и содержанию повести «Теория невероятностей»', '2026-06-01 10:46:59', '2026-06-04 13:06:37', 2, NULL),
(9, 'Мария Федотова-Нулгынэт: «Игра в камешки»', 'Тест по автобиографической повести эвенской писательницы', '2026-06-01 10:46:59', '2026-06-04 13:06:37', 3, NULL),
(10, 'Сэмэн Тумат: «Жизнь на острове среди моря»', 'Тест по рассказу о жизни мальчика Сэмэнчика на Севере', '2026-06-01 10:46:59', '2026-06-01 10:49:04', 4, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `test_results`
--

CREATE TABLE `test_results` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `test_results`
--

INSERT INTO `test_results` (`id`, `test_id`, `user_id`, `user_name`, `user_email`, `score`, `total`, `percentage`, `created_at`) VALUES
(1, 7, NULL, 'артем пк', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-08 09:29:46'),
(2, 7, NULL, 'артем пк1', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-08 09:43:54'),
(3, 8, NULL, 'артем пк12', 'uartem2506@gmail.com', 5, 10, 50, '2026-06-08 09:44:15'),
(4, 7, NULL, 'артем тел1', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-08 09:52:39'),
(5, 8, NULL, 'артем тел12', 'uartem2506@gmail.com', 5, 10, 50, '2026-06-08 09:53:08'),
(6, 7, NULL, 'артем тел123', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-08 09:55:35'),
(7, 7, NULL, 'артем пк2', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-08 10:15:10'),
(8, 7, NULL, 'артем пк22', 'uartem2506@gmail.com', 3, 10, 30, '2026-06-10 15:19:15'),
(9, 7, 1, 'артем пк1', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-10 16:29:12'),
(10, 7, 1, 'артем пк', 'uartem2506@gmail.com', 2, 10, 20, '2026-06-10 16:29:31'),
(11, 7, 1, 'artem1', 'uztin1980@gmail.com', 5, 10, 50, '2026-06-10 16:32:38'),
(12, 7, 1, 'artem 2', 'memerchill14@gmail.com', 5, 10, 50, '2026-06-10 16:33:16'),
(13, 8, 1, 'asdasd', 'uartem2506@gmail.com', 3, 10, 30, '2026-06-10 16:40:18'),
(14, 9, 1, 'asdasd', 'uartem2506@gmail.com', 3, 10, 30, '2026-06-10 16:40:35'),
(15, 10, 1, 'asdasd', 'uartem2506@gmail.com', 6, 10, 60, '2026-06-10 16:40:48'),
(16, 9, NULL, 'asdasd', 'uartem2506@gmail.com', 4, 10, 40, '2026-06-10 16:41:09'),
(17, 7, 2, 'Николай Устинов', 'uztin1980@gmail.com', 2, 10, 20, '2026-06-10 17:00:07'),
(18, 8, 2, 'Николай Устинов', 'uztin1980@gmail.com', 5, 10, 50, '2026-06-10 17:00:17'),
(19, 9, 2, 'Николай Устинов', 'uztin1980@gmail.com', 2, 10, 20, '2026-06-10 17:00:26'),
(20, 10, 2, 'Николай Устинов', 'uztin1980@gmail.com', 4, 10, 40, '2026-06-10 17:00:38'),
(21, 7, 4, 'фыв фыввыф', 'uartem2206@gmail.com', 4, 10, 40, '2026-06-14 04:47:33'),
(22, 8, 4, 'фыв фыввыф', 'uartem2206@gmail.com', 0, 10, 0, '2026-06-14 04:47:47'),
(23, 9, 4, 'фыв фыввыф', 'uartem2206@gmail.com', 3, 10, 30, '2026-06-14 04:47:58'),
(24, 10, 4, 'фыв фыввыф', 'uartem2206@gmail.com', 4, 10, 40, '2026-06-14 04:48:08'),
(25, 7, 1, 'Артем Устинов Николаевич', 'uztin1980@gmail.com', 4, 10, 40, '2026-06-14 04:49:37');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone`, `email`, `password`, `created_at`) VALUES
(1, 'Артем Устинов Николаевич', '+79142347856', 'uztin1980@gmail.com', '$2y$10$WzaNvKzZPb2kH2TE9wYB3OznwudTkZb0HFVhZSWaMR5UZV6NTFUFu', '2026-06-10 16:16:49'),
(2, 'Николай Устинов', '+79141231212', 'uztin1980@gmail.com', '$2y$10$HD/c1pQ8M81z.hweb15vP.ZZ3HHXP50SCyHY2PVtD3Pdyr5FBzBIW', '2026-06-10 16:59:28'),
(3, 'Николай Устинов', '+79141232323', 'uztin1980@gmail.com', '$2y$10$hhX0j7DbICRg8OKH3x6bOO6GVY087CMPaF8XkFLk3qWfXX9sKy9Kq', '2026-06-10 17:43:12'),
(4, 'фыв фыввыф', '+79143453434', 'uartem2206@gmail.com', '$2y$10$YRXCCbAlTW8wmQ3mOD04veaCnBCsAkgEAwloDi3rQ7/vz0GPGmSkO', '2026-06-14 04:46:52');

-- --------------------------------------------------------

--
-- Структура таблицы `writer_of_month`
--

CREATE TABLE `writer_of_month` (
  `id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'writer.jpg',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `writer_of_month`
--

INSERT INTO `writer_of_month` (`id`, `name`, `description`, `image_path`, `updated_at`) VALUES
(1, 'Сергей Баруздин', 'Известный советский писатель, поэт и публицист, получивший наибольшую популярность как автор классических произведений для детей и юношества.', 'writer_1780310988.jpg', '2026-06-01 11:32:31');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `writer_id` (`writer_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Индексы таблицы `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Индексы таблицы `writer_of_month`
--
ALTER TABLE `writer_of_month`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`writer_id`) REFERENCES `writer_of_month` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
