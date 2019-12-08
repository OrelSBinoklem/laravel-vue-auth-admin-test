-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 08 2019 г., 19:37
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myprogcenter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bans`
--

CREATE TABLE `bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `bannable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bannable_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bans`
--

INSERT INTO `bans` (`id`, `bannable_type`, `bannable_id`, `created_by_type`, `created_by_id`, `comment`, `expired_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 28, 'App\\User', 2, NULL, '2019-04-15 21:35:00', NULL, '2018-12-15 22:35:00', '2018-12-29 22:41:46'),
(2, 'App\\User', 29, 'App\\User', 2, NULL, '2019-01-15 22:35:18', '2018-12-16 18:02:07', '2018-12-15 22:35:18', '2018-12-16 18:02:07'),
(3, 'App\\User', 30, 'App\\User', 2, NULL, NULL, '2018-12-16 17:59:56', '2018-12-16 17:48:18', '2018-12-16 17:59:56'),
(4, 'App\\User', 31, 'App\\User', 2, NULL, NULL, '2018-12-16 18:03:01', '2018-12-16 18:02:56', '2018-12-16 18:03:01'),
(5, 'App\\User', 32, 'App\\User', 2, NULL, NULL, '2018-12-16 18:04:19', '2018-12-16 18:04:04', '2018-12-16 18:04:19'),
(6, 'App\\User', 32, 'App\\User', 2, NULL, NULL, '2018-12-16 18:04:19', '2018-12-16 18:04:09', '2018-12-16 18:04:19'),
(7, 'App\\User', 32, 'App\\User', 2, NULL, NULL, '2018-12-16 18:04:19', '2018-12-16 18:04:14', '2018-12-16 18:04:19'),
(8, 'App\\User', 33, 'App\\User', 2, NULL, NULL, '2018-12-29 02:51:49', '2018-12-16 18:05:36', '2018-12-29 02:51:49'),
(9, 'App\\User', 34, 'App\\User', 2, NULL, '2018-12-16 18:08:28', NULL, '2018-12-16 18:07:28', '2018-12-16 18:07:28'),
(10, 'App\\User', 33, 'App\\User', 2, NULL, '2019-03-15 22:35:00', NULL, '2018-12-29 02:52:05', '2018-12-29 02:52:05'),
(11, 'App\\User', 34, 'App\\User', 2, NULL, '2019-05-21 22:30:00', NULL, '2018-12-29 02:52:21', '2019-05-21 19:26:57'),
(12, 'App\\User', 24, 'App\\User', 2, NULL, '2018-12-31 05:40:00', NULL, '2018-12-30 03:39:22', '2018-12-30 03:39:22'),
(13, 'App\\User', 35, 'App\\User', 2, NULL, '2019-01-23 13:25:00', NULL, '2019-01-21 11:24:44', '2019-01-21 11:24:44'),
(14, 'App\\User', 41, 'App\\User', 2, NULL, '2019-01-25 18:40:00', '2019-01-25 08:15:40', '2019-01-24 16:36:34', '2019-01-25 08:15:40'),
(15, 'App\\User', 42, 'App\\User', 2, NULL, '2019-01-25 18:40:00', '2019-01-25 08:18:55', '2019-01-24 16:36:34', '2019-01-25 08:18:55'),
(16, 'App\\User', 43, 'App\\User', 2, NULL, '2019-01-24 06:45:00', NULL, '2019-01-24 16:37:04', '2019-01-24 16:37:04'),
(17, 'App\\User', 44, 'App\\User', 2, NULL, '2019-01-24 06:45:00', '2019-01-25 08:20:26', '2019-01-24 16:37:04', '2019-01-25 08:20:26'),
(18, 'App\\User', 43, 'App\\User', 2, NULL, '2019-01-24 06:45:00', NULL, '2019-01-24 16:39:12', '2019-01-24 16:39:12'),
(19, 'App\\User', 44, 'App\\User', 2, NULL, '2019-01-24 06:45:00', '2019-01-25 08:20:26', '2019-01-24 16:39:12', '2019-01-25 08:20:26'),
(20, 'App\\User', 45, 'App\\User', 2, NULL, '2019-01-24 06:50:00', NULL, '2019-01-24 16:39:39', '2019-01-24 16:39:39'),
(21, 'App\\User', 46, 'App\\User', 2, NULL, '2019-01-24 06:50:00', NULL, '2019-01-24 16:39:39', '2019-01-24 16:39:39'),
(22, 'App\\User', 47, 'App\\User', 2, NULL, '2019-01-24 06:55:00', NULL, '2019-01-24 16:41:41', '2019-01-24 16:41:41'),
(23, 'App\\User', 48, 'App\\User', 2, NULL, '2019-01-24 06:55:00', NULL, '2019-01-24 16:41:41', '2019-01-24 16:41:41'),
(24, 'App\\User', 44, 'App\\User', 2, NULL, '2019-01-24 06:55:00', '2019-01-25 08:20:26', '2019-01-24 16:42:34', '2019-01-25 08:20:26'),
(25, 'App\\User', 47, 'App\\User', 2, NULL, '2019-01-24 06:55:00', NULL, '2019-01-24 16:42:34', '2019-01-24 16:42:34'),
(26, 'App\\User', 48, 'App\\User', 2, NULL, '2019-01-24 06:55:00', NULL, '2019-01-24 16:42:34', '2019-01-24 16:42:34'),
(27, 'App\\User', 27, 'App\\User', 2, NULL, '2019-01-25 18:45:00', NULL, '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(28, 'App\\User', 44, 'App\\User', 2, NULL, '2019-01-25 18:45:00', '2019-01-25 08:20:26', '2019-01-24 16:43:15', '2019-01-25 08:20:26'),
(29, 'App\\User', 47, 'App\\User', 2, NULL, '2019-01-25 18:45:00', NULL, '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(30, 'App\\User', 48, 'App\\User', 2, NULL, '2019-01-25 18:45:00', NULL, '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(31, 'App\\User', 38, 'App\\User', 2, NULL, '2019-01-26 19:40:00', '2019-01-25 17:39:10', '2019-01-25 17:39:00', '2019-01-25 17:39:10'),
(32, 'App\\User', 35, 'App\\User', 2, NULL, NULL, NULL, '2019-05-21 19:27:10', '2019-05-21 19:27:10');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `published` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `parent_id`, `published`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(11, 'Плагины', 'plugins', 17, 1, 2, 2, '2019-09-25 13:16:37', '2019-10-08 17:49:50'),
(12, 'Авторские плагины', 'authors-plugins', 17, 1, 2, 2, '2019-09-25 13:18:30', '2019-10-08 17:49:54'),
(13, 'Заготовки', 'blanks', 17, 1, 2, 2, '2019-09-25 13:19:16', '2019-10-08 17:49:58'),
(14, 'Заготовки мелких плагинов под собственную разработку', 'mini-plugins-for-edit', 12, 1, 2, 2, '2019-09-25 13:19:43', '2019-10-08 17:56:19'),
(17, 'Предназначение кода', 'code-purpose', NULL, 1, 2, 2, '2019-10-08 17:49:33', '2019-10-08 17:49:33'),
(18, 'Технологии', 'technologies', NULL, 1, 2, 2, '2019-10-08 17:51:00', '2019-10-08 17:51:00'),
(19, 'Vue', 'vue', 18, 1, 2, 2, '2019-10-08 17:51:29', '2019-10-08 17:53:22'),
(20, 'JQuery', 'jquery', 18, 1, 2, 2, '2019-10-08 17:51:52', '2019-10-08 17:53:25'),
(21, 'WordPress', 'wordpress', 18, 1, 2, 2, '2019-10-08 17:53:01', '2019-10-08 17:53:27'),
(22, 'Laravel', 'laravel', 18, 1, 2, 2, '2019-10-08 17:53:16', '2019-10-08 17:53:29'),
(23, 'Фиксы плагина', 'fixes-plugin', 11, 1, 2, 2, '2019-10-08 17:57:22', '2019-10-08 17:59:28'),
(24, 'Расширение плагина', 'extend-plugin', 11, 1, 2, 2, '2019-10-08 17:59:23', '2019-10-08 17:59:32'),
(25, 'Веб-программирование', 'web-programming', NULL, 1, 2, 2, '2019-10-08 18:01:26', '2019-10-08 18:01:26'),
(26, 'Слайдеры', 'sliders', 25, 1, 2, 2, '2019-10-08 18:01:37', '2019-10-08 18:06:05'),
(27, 'Попапы', 'popups', 25, 1, 2, 2, '2019-10-08 18:01:55', '2019-10-08 18:06:09'),
(28, 'Интерфейс', 'interface', 25, 1, 2, 2, '2019-10-08 18:02:11', '2019-10-08 18:06:11'),
(29, 'Мультимедиа', 'multimedia', 25, 1, 2, 2, '2019-10-08 18:02:24', '2019-10-08 18:06:13'),
(31, 'Графика', 'graphics', 25, 1, 2, 2, '2019-10-08 18:02:55', '2019-10-08 18:06:18'),
(32, 'ИИ', 'ai', 25, 1, 2, 2, '2019-10-08 18:03:07', '2019-10-08 18:06:20'),
(34, 'Методики программирования', 'techniques', 38, 1, 2, 2, '2019-10-08 18:03:40', '2019-10-08 18:07:35'),
(35, 'Алгоритмика', 'algorithmics', 38, 1, 2, 2, '2019-10-08 18:03:52', '2019-10-08 18:07:36'),
(36, 'Хард плагины', 'hard-plugins', 25, 1, 2, 2, '2019-10-08 18:05:48', '2019-10-08 18:10:24'),
(37, 'Сервисы', 'services', 25, 1, 2, 2, '2019-10-08 18:06:01', '2019-10-08 18:06:27'),
(38, 'Программирование', 'programming', 25, 1, 2, 2, '2019-10-08 18:07:17', '2019-10-08 18:07:24'),
(39, 'Паттерны проектирования', 'programming-design-patterns', 38, 1, 2, 2, '2019-10-08 18:09:22', '2019-10-08 18:10:12'),
(40, 'Паттерны ООП', 'oop-patterns', 38, 1, 2, 2, '2019-10-08 18:10:01', '2019-10-08 18:10:16'),
(41, 'Графика CSS', 'graphics-css', 31, 1, 2, 2, '2019-10-08 18:14:17', '2019-10-08 18:16:03'),
(42, 'Графика SVG', 'graphics-svg', 31, 1, 2, 2, '2019-10-08 18:14:44', '2019-10-08 18:16:07'),
(43, 'Нативная графика', 'native-graphics', 31, 1, 2, 2, '2019-10-08 18:15:58', '2019-10-08 18:16:10'),
(44, 'Цена', 'price', NULL, 1, 2, 2, '2019-10-14 09:30:31', '2019-10-14 09:30:31'),
(45, 'Платное', 'paid', 44, 1, 2, 2, '2019-10-14 09:31:08', '2019-10-14 10:12:15'),
(46, 'Бесплатное', 'free', 44, 1, 2, 2, '2019-10-14 09:31:23', '2019-10-14 10:12:07'),
(47, 'Условно бесплатное', 'shareware', 44, 1, 2, 2, '2019-10-14 09:32:17', '2019-10-14 10:12:11'),
(54, 'Наборы', 'sets', NULL, 1, 2, 2, '2019-10-17 10:32:06', '2019-10-17 10:32:06'),
(56, 'Лэндинг-мини', 'landing-mini', 54, 1, 2, 2, '2019-10-17 10:33:04', '2019-10-17 10:33:08'),
(57, 'Лэндинг-норма', 'landing-normal', 54, 1, 2, 2, '2019-10-17 10:33:41', '2019-10-17 10:33:44'),
(58, 'Рэйтинг', 'rating', NULL, 1, 2, 2, '2019-10-17 10:34:15', '2019-10-17 10:34:15'),
(59, 'Популярное без аналогов', 'best', 58, 1, 2, 2, '2019-10-17 10:35:05', '2019-10-29 06:46:39');

-- --------------------------------------------------------

--
-- Структура таблицы `categoryables`
--

CREATE TABLE `categoryables` (
  `category_id` int(11) NOT NULL,
  `categoryable_id` int(11) NOT NULL,
  `categoryable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categoryables`
--

INSERT INTO `categoryables` (`category_id`, `categoryable_id`, `categoryable_type`) VALUES
(1, 1, 'App\\ContentJSPlugin'),
(7, 1, 'App\\ContentJSPlugin'),
(7, 9, 'App\\ContentJSPlugin'),
(11, 10, 'App\\ContentJSPlugin'),
(20, 10, 'App\\ContentJSPlugin'),
(26, 10, 'App\\ContentJSPlugin'),
(46, 10, 'App\\ContentJSPlugin'),
(56, 10, 'App\\ContentJSPlugin'),
(59, 10, 'App\\ContentJSPlugin'),
(28, 7, 'App\\ContentJSPlugin'),
(57, 10, 'App\\ContentJSPlugin');

-- --------------------------------------------------------

--
-- Структура таблицы `content_j_s_plugins`
--

CREATE TABLE `content_j_s_plugins` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_short` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `content_j_s_plugins`
--

INSERT INTO `content_j_s_plugins` (`id`, `title`, `slug`, `description_short`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `published`, `created_by`, `modified_by`, `viewed`, `created_at`, `updated_at`) VALUES
(1, 'fggfgf22', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 1, 2, 2, 0, '2019-03-28 14:46:38', '2019-04-12 16:37:47'),
(3, 'fggfgf', 'fggfgf2', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 1, 2, 2, 0, '2019-03-28 14:58:20', '2019-03-28 14:58:20'),
(5, 'fggfgf', 'fggfgf23', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 'fggfgf', 0, 2, 2, 0, '2019-03-28 15:00:51', '2019-03-30 18:42:20'),
(6, 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 1, 2, 2, 0, '2019-03-28 15:02:39', '2019-03-28 15:02:39'),
(7, 'Теест', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f, fff', 1, 2, 2, 0, '2019-04-12 12:30:36', '2019-05-16 14:22:30'),
(8, 'sdfsdfsdf55', 'dsfdfsdf', 'fggfgf', 'dfdsf', 'sdfds', 'sdfsdf', 'sdfsdf', 1, 2, 2, 0, '2019-04-12 16:40:33', '2019-04-12 16:40:33'),
(9, 'Тест2', 'bottomdd', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 'sdfsdfsdf55f', 1, 2, 2, 0, '2019-04-27 17:26:14', '2019-04-27 17:26:14'),
(10, 'Slick', 'slick-slider', 'Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдераПлагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера Плагин slick слайдера', 'контент', 'slick', 'Плагин slick слайдера', 'slick, sliders', 1, 2, 2, 0, '2019-09-17 07:05:53', '2019-09-24 16:57:55'),
(11, 'Owl Carousel', 'owl-carousel', 'Слайдер', 'Контент', 'Слайдер', 'Слайдер', 'owl-carousel, slider', 1, 2, 2, 0, '2019-09-17 07:10:29', '2019-09-17 07:10:29');

-- --------------------------------------------------------

--
-- Структура таблицы `content_j_s_plugins_meta`
--

CREATE TABLE `content_j_s_plugins_meta` (
  `id` int(10) UNSIGNED NOT NULL,
  `plugin_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'null',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `content_j_s_plugins_meta`
--

INSERT INTO `content_j_s_plugins_meta` (`id`, `plugin_id`, `type`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 3, 'array', 'alerts', '[]', '2019-03-28 14:58:20', '2019-03-28 14:58:20'),
(2, 5, 'array', 'alerts', '[{\"title\":\"dfd\",\"text\":\"dsfs\"},{\"title\":\"dd\",\"text\":\"dd\"}]', '2019-03-28 15:00:51', '2019-03-28 15:00:51'),
(3, 6, 'array', 'alerts', '[{\"title\":\"rtert\",\"text\":\"ertre\"},{\"title\":\"d\",\"text\":\"d\"}]', '2019-03-28 15:02:39', '2019-04-12 16:39:53'),
(4, 7, 'array', 'alerts', '[{\"title\":\"ddd\",\"text\":\"dd\"},{\"title\":\"ghh2222\",\"text\":\"jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj\"}]', '2019-04-12 12:30:37', '2019-04-15 23:19:31'),
(5, 8, 'array', 'alerts', '[{\"title\":\"ddd\",\"text\":\"ddddddd\"}]', '2019-04-12 16:40:33', '2019-04-12 16:40:33'),
(6, 7, 'array', 'editors', '[{\"title\":null,\"text\":\"<h1>\\u0401<\\/h1>\",\"slug\":\"xx3\"},{\"slug\":\"xx2\",\"text\":\"<h1>\\u0401<\\/h1>\"},{\"slug\":\"xx\",\"text\":\"<h1>\\u0401<\\/h1>\"}]', '2019-04-14 09:45:40', '2019-04-15 23:19:31'),
(7, 9, 'array', 'alerts', '[]', '2019-04-27 17:26:15', '2019-04-27 17:26:15'),
(8, 9, 'array', 'editors', '[]', '2019-04-27 17:26:15', '2019-04-27 17:26:15'),
(9, 7, 'array', 'positions', '{\"alerts_scroll_test\":{\"data\":{\"name\":\"\\u0422\\u0435\\u0441\\u0442 \\u0441\\u043a\\u0440\\u043e\\u043b\\u043b\\u0430 \\u043f\\u043e \\u0445\\u0435\\u0448\\u0430\\u043c\"},\"rules\":[{\"name\":\"regex:\\/^alert$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 1<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 1\",\"slug\":\"alert1\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 2<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 2\",\"slug\":\"alert2\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 3<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 3\",\"slug\":\"alert3\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 4<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 4\",\"slug\":\"alert4\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 5<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 5\",\"slug\":\"alert5\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 6<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 6\",\"slug\":\"alert6\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 7<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 7\",\"slug\":\"alert7\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 8<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 8\",\"slug\":\"alert8\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 9<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 9\",\"slug\":\"alert9\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 10<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 10\",\"slug\":\"alert10\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 11<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 11\",\"slug\":\"alert11\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 12<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 12\",\"slug\":\"alert12\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 13<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 13\",\"slug\":\"alert13\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 14<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 14\",\"slug\":\"alert14\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 15<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 15\",\"slug\":\"alert15\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 16<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 16\",\"slug\":\"alert16\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 17<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 17\",\"slug\":\"alert17\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 18<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 18\",\"slug\":\"alert18\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 19<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 19\",\"slug\":\"alert19\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 20<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 20\",\"slug\":\"alert20\",\"group\":\"properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 21<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 21\",\"slug\":\"alert21\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 2<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 22\",\"slug\":\"alert22\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 23<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 23\",\"slug\":\"alert23\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 24<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 24\",\"slug\":\"alert24\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 25<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 25\",\"slug\":\"alert25\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 26<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 26\",\"slug\":\"alert26\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 27<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 27\",\"slug\":\"alert27\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 28<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 28\",\"slug\":\"alert28\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 29<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 29\",\"slug\":\"alert29\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 30<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 30\",\"slug\":\"alert30\",\"group\":\"static_properties\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 31<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 31\",\"slug\":\"alert31\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 32<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 32\",\"slug\":\"alert32\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 33<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 33\",\"slug\":\"alert33\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 34<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 34\",\"slug\":\"alert34\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 35<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 35\",\"slug\":\"alert35\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 36<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 36\",\"slug\":\"alert36\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 37<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 37\",\"slug\":\"alert37\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 38<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 38\",\"slug\":\"alert38\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 39<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 39\",\"slug\":\"alert39\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 40<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 40\",\"slug\":\"alert40\",\"group\":\"methods\"}}},{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<h4>\\u0422\\u0435\\u0441\\u0442 41<\\/h4>\",\"navHash\":{\"title\":\"\\u0410\\u043b\\u0435\\u0440\\u0442 41\",\"slug\":\"alert41\",\"group\":\"methods\"}}}]},\"description\":{\"data\":{\"name\":\"\\u0417\\u0430\\u0447\\u0435\\u043c \\u0438 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^casual_html$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"casual_html\",\"props\":{\"html\":\"\\u041e\\u0434\\u0438\\u043d \\u0438\\u0437 \\u0441\\u0430\\u043c\\u044b\\u0445 \\u043f\\u043e\\u043f\\u0443\\u043b\\u044f\\u0440\\u043d\\u044b\\u0445 \\u0441\\u043b\\u0430\\u0439\\u0434\\u0435\\u0440\\u043e\\u0432. \\u0423\\u043c\\u0435\\u0435\\u0442 \\u043e\\u0442\\u043e\\u0431\\u0440\\u0430\\u0436\\u0430\\u0442\\u044c \\u0441\\u0440\\u0430\\u0437\\u0443 \\u043d\\u0435\\u0441\\u043a\\u043e\\u043b\\u044c\\u043a\\u043e \\u043a\\u0430\\u0440\\u0442\\u0438\\u043d\\u043e\\u043a, \\u0443\\u043c\\u0435\\u0435\\u0442 \\u0432\\u0435\\u0440\\u0442\\u0438\\u043a\\u0430\\u043b\\u044c\\u043d\\u0443\\u044e \\u043e\\u0440\\u0438\\u0435\\u043d\\u0442\\u0430\\u0446\\u0438\\u044e, \\u043f\\u043e\\u0442\\u0434\\u0435\\u0440\\u0436\\u043a\\u0430 \\u0430\\u0434\\u0430\\u043f\\u0442\\u0438\\u0432\\u0430, \\u0433\\u0438\\u0431\\u043a\\u043e\\u0435 api - \\u043c\\u043e\\u0436\\u043d\\u043e \\u0437\\u0430\\u043c\\u0443\\u0442\\u0438\\u0442\\u044c \\u0433\\u0430\\u043b\\u043b\\u0435\\u0440\\u0435\\u044e \\u043e\\u0431\\u044a\\u0435\\u0434\\u0438\\u043d\\u0438\\u0432 2 \\u0441\\u043b\\u0430\\u0439\\u0434\\u0435\\u0440\\u0430\"}}]},\"tut_alerts\":{\"data\":{\"name\":\"\\u041d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0430\\u0442\\u043a\\u0438 \\u043f\\u043b\\u0430\\u0433\\u0438\\u043d\\u0430\"},\"rules\":[{\"name\":\"regex:\\/^callout$\\/mi\",\"props\":{\"variant\":[\"regex:\\/^danger|warning$\\/im\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"callout\",\"props\":{\"variant\":\"danger\",\"heading\":\"\\u0422\\u0435\\u0441\\u0442\",\"html\":\"<b>555555<\\/b>\"}}]},\"use_code\":{\"data\":{\"name\":\"\\u041a\\u043e\\u0434 \\u0434\\u043b\\u044f \\u043a\\u043e\\u043f\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f\"},\"rules\":[{\"name\":\"regex:\\/^copy_code$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"copy_code\",\"props\":{\"type_visible\":\"casual\",\"getter_store_priority_type_code\":\"interface\\/priorityCopyTypeCode\",\"count_editors\":\"5\",\"min_lines\":\"50\",\"max_lines\":\"10\",\"editors\":[{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 1\",\"variant_or_group\":\"styles\"},{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 2\",\"variant_or_group\":\"html\"},{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 3\",\"variant_or_group\":\"html\"},{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 4\",\"variant_or_group\":\"html\"},{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 5\",\"variant_or_group\":\"html\"}],\"navHash\":{\"title\":\"Slides\",\"slug\":\"slides\",\"group\":\"properties\"}},\"positions\":{\"editor0\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 1\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:css,sass,scss,less,stylus\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"css\",\"min_lines\":\"5\",\"max_lines\":\"10\",\"code\":\"cc\"}},{\"name\":\"code_editor\",\"props\":{\"variant\":\"sass\",\"min_lines\":\"5\",\"max_lines\":\"10\",\"code\":\"cc2\"}}]},\"editor1\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 2\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"regex:\\/^html$\\/im\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"vvvv\"}}]},\"editor2\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 3\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"regex:\\/^html$\\/im\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"ghgfhfghgh\"}}]},\"editor3\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 4\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"regex:\\/^html$\\/im\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"50\",\"max_lines\":\"50\",\"code\":\"ll\"}}]},\"editor4\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 5\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"regex:\\/^html$\\/im\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"50\",\"max_lines\":\"50\",\"code\":\"ll\"}}]}}}]}}', '2019-06-02 17:04:50', '2019-10-17 11:08:54'),
(10, 10, 'array', 'positions', '{\"alerts_scroll_test\":{\"data\":{\"name\":\"\\u0422\\u0435\\u0441\\u0442 \\u0441\\u043a\\u0440\\u043e\\u043b\\u043b\\u0430 \\u043f\\u043e \\u0445\\u0435\\u0448\\u0430\\u043c\"},\"rules\":[{\"name\":\"regex:\\/^alert$\\/mi\",\"errorCount\":\"false\"}]},\"description\":{\"data\":{\"name\":\"\\u0417\\u0430\\u0447\\u0435\\u043c \\u0438 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^casual_html$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"casual_html\",\"props\":{\"html\":\"\\u0420\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442\"}}]},\"tut_alerts\":{\"data\":{\"name\":\"\\u041d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0430\\u0442\\u043a\\u0438 \\u043f\\u043b\\u0430\\u0433\\u0438\\u043d\\u0430\"},\"rules\":[{\"name\":\"regex:\\/^callout$\\/mi\",\"props\":{\"variant\":[\"regex:\\/^danger|warning$\\/im\"]},\"errorCount\":\"false\"}]},\"use_code\":{\"data\":{\"name\":\"\\u041a\\u043e\\u0434 \\u0434\\u043b\\u044f \\u043a\\u043e\\u043f\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f\"},\"rules\":[{\"name\":\"regex:\\/^copy_code$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"copy_code\",\"props\":{\"type_visible\":\"vertical_tabs\",\"getter_store_priority_type_code\":\"interface\\/priorityCopyTypeCode\",\"count_editors\":\"4\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"editors\":[{\"heading\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0438\\u0442\\u044c \\u0441\\u0442\\u0438\\u043b\\u0438\",\"variant_or_group\":\"layouts\"},{\"heading\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0438\\u0442\\u044c \\u0441\\u043a\\u0440\\u0438\\u043f\\u0442\",\"variant_or_group\":\"layouts\"},{\"heading\":\"\\u041f\\u0440\\u0438\\u043c\\u0435\\u0440 - \\u0440\\u0430\\u0437\\u043c\\u0435\\u0442\\u043a\\u0430\",\"variant_or_group\":\"layouts\"},{\"heading\":\"\\u041f\\u0440\\u0438\\u043c\\u0435\\u0440 - js\",\"variant_or_group\":\"js\"}],\"navHash\":{\"title\":null,\"slug\":null,\"group\":\"null\"}},\"positions\":{\"editor0\":{\"data\":{\"name\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0438\\u0442\\u044c \\u0441\\u0442\\u0438\\u043b\\u0438\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:jade,html\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"<link rel=\\\"stylesheet\\\" type=\\\"text\\/css\\\" href=\\\"js\\/slick-slider\\/slick.css\\\"\\/>\"}},{\"name\":\"code_editor\",\"props\":{\"variant\":\"jade\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"link(rel=\'stylesheet\' type=\'text\\/css\' href=\'js\\/slick-slider\\/slick.css\')\"}}]},\"editor1\":{\"data\":{\"name\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0438\\u0442\\u044c \\u0441\\u043a\\u0440\\u0438\\u043f\\u0442\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:jade,html\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"<script type=\\\"text\\/javascript\\\" src=\\\"js\\/slick-slider\\/slick.min.js\\\"><\\/script>\"}},{\"name\":\"code_editor\",\"props\":{\"variant\":\"jade\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"script(type=\'text\\/javascript\' src=\'js\\/slick-slider\\/slick.min.js\')\"}}]},\"editor2\":{\"data\":{\"name\":\"\\u041f\\u0440\\u0438\\u043c\\u0435\\u0440 - \\u0440\\u0430\\u0437\\u043c\\u0435\\u0442\\u043a\\u0430\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:jade,html\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"<div class=\\\"main-slider\\\">\\r\\n    <div><h2>1<\\/h2><\\/div>\\r\\n    <div><h2>2<\\/h2><\\/div>\\r\\n    <div><h2>3<\\/h2><\\/div>\\r\\n    <div><h2>4<\\/h2><\\/div>\\r\\n    <div><h2>5<\\/h2><\\/div>\\r\\n    <div><h2>6<\\/h2><\\/div>\\r\\n    <div><h2>7<\\/h2><\\/div>\\r\\n<\\/div>\"}},{\"name\":\"code_editor\",\"props\":{\"variant\":\"jade\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\".main-slider\\n  div\\n    h2 1\\n  div\\n    h2 2\\n  div\\n    h2 3\\n  div\\n    h2 4\\n  div\\n    h2 5\\n  div\\n    h2 6\\n  div\\n    h2 7\"}}]},\"editor3\":{\"data\":{\"name\":\"\\u041f\\u0440\\u0438\\u043c\\u0435\\u0440 - js\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:javascript,typescript,coffee\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"javascript\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"$(\'.main-slider\').slick({\\r\\n    slidesToShow: 5,\\r\\n    slidesToScroll: 5,\\r\\n    infinite: false,\\r\\n    responsive: [\\r\\n      {\\r\\n        breakpoint: 1280,\\r\\n        settings: {\\r\\n          slidesToShow: 4,\\r\\n          slidesToScroll: 4\\r\\n        }\\r\\n      },\\r\\n      {\\r\\n        breakpoint: 768,\\r\\n        settings: {\\r\\n          slidesToShow: 3,\\r\\n          slidesToScroll: 3\\r\\n        }\\r\\n      },\\r\\n      {\\r\\n        breakpoint: 640,\\r\\n        settings: {\\r\\n          slidesToShow: 2,\\r\\n          slidesToScroll: 2\\r\\n        }\\r\\n      }\\r\\n    ]\\r\\n});\"}}]}}}]},\"content\":{\"data\":{\"name\":\"\\u041f\\u0440\\u043e\\u0441\\u0442\\u043e\\u0439 \\u043a\\u043e\\u043d\\u0442\\u0435\\u043d\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^.+$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"markdown\",\"props\":{\"code\":\"### Hello world!2\"}}]}}', '2019-09-17 07:05:53', '2019-12-07 09:04:28'),
(11, 11, 'array', 'positions', '{\"alerts_scroll_test\":{\"data\":{\"name\":\"\\u0422\\u0435\\u0441\\u0442 \\u0441\\u043a\\u0440\\u043e\\u043b\\u043b\\u0430 \\u043f\\u043e \\u0445\\u0435\\u0448\\u0430\\u043c\"},\"rules\":[{\"name\":\"regex:\\/^alert$\\/mi\",\"errorCount\":\"false\"}]},\"description\":{\"data\":{\"name\":\"\\u0417\\u0430\\u0447\\u0435\\u043c \\u0438 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^casual_html$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"casual_html\",\"props\":{\"html\":\"<h2>\\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u04422<\\/h2>\"}}]},\"tut_alerts\":{\"data\":{\"name\":\"\\u041d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0430\\u0442\\u043a\\u0438 \\u043f\\u043b\\u0430\\u0433\\u0438\\u043d\\u0430\"},\"rules\":[{\"name\":\"regex:\\/^callout$\\/mi\",\"props\":{\"variant\":[\"regex:\\/^danger|warning$\\/im\"]},\"errorCount\":\"false\"}]},\"use_code\":{\"data\":{\"name\":\"\\u041a\\u043e\\u0434 \\u0434\\u043b\\u044f \\u043a\\u043e\\u043f\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f\"},\"rules\":[{\"name\":\"regex:\\/^copy_code$\\/mi\",\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"copy_code\",\"props\":{\"type_visible\":\"row\",\"getter_store_priority_type_code\":\"interface\\/priorityCopyTypeCode\",\"count_editors\":\"2\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"editors\":[{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 1\",\"variant_or_group\":\"layouts\"},{\"heading\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 2\",\"variant_or_group\":\"styles\"}],\"navHash\":{\"title\":\"\\u041f\\u043b\\u0430\\u0433\\u0438\\u043d\",\"slug\":\"teeeest\",\"group\":\"static_properties\"}},\"positions\":{\"editor0\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 1\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:jade,html\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"html\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\"<h2>\\u0422\\u0435\\u0441\\u0442<\\/h2>\"}}]},\"editor1\":{\"data\":{\"name\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u043e\\u0440 2\"},\"rules\":[{\"count\":\"1-5\",\"props\":{\"variant\":[\"in:css,sass,scss,less,stylus\"]},\"errorCount\":\"false\"}],\"widgets\":[{\"name\":\"code_editor\",\"props\":{\"variant\":\"css\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\".red {\\n    color: red;\\n}\"}},{\"name\":\"code_editor\",\"props\":{\"variant\":\"sass\",\"min_lines\":\"10\",\"max_lines\":\"10\",\"code\":\".red\\n    color: red\"}}]}}}]},\"content\":{\"data\":{\"name\":\"\\u041f\\u0440\\u043e\\u0441\\u0442\\u043e\\u0439 \\u043a\\u043e\\u043d\\u0442\\u0435\\u043d\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^.+$\\/mi\",\"errorCount\":\"false\"}]}}', '2019-09-17 07:10:29', '2019-12-07 17:28:10'),
(12, 9, 'array', 'positions', '{\"alerts_scroll_test\":{\"data\":{\"name\":\"\\u0422\\u0435\\u0441\\u0442 \\u0441\\u043a\\u0440\\u043e\\u043b\\u043b\\u0430 \\u043f\\u043e \\u0445\\u0435\\u0448\\u0430\\u043c\"},\"rules\":[{\"name\":\"regex:\\/^alert$\\/mi\",\"errorCount\":false}],\"widgets\":[{\"name\":\"alert\",\"props\":{\"variant\":\"primary\",\"html\":\"<b>\\u0422\\u0435\\u0441\\u0442<\\/b>\",\"navHash\":{\"title\":\"\\u0422\\u0435\\u0441\\u0442 \\u0441\\u0435\\u043a\\u0446\\u0438\\u044f\",\"slug\":\"test-s\",\"group\":\"methods\"}},\"positions\":[]}]},\"description\":{\"data\":{\"name\":\"\\u0417\\u0430\\u0447\\u0435\\u043c \\u0438 \\u043a\\u0430\\u043a \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442\"},\"rules\":[{\"name\":\"regex:\\/^casual_html$\\/mi\",\"errorCount\":false}],\"widgets\":[]},\"tut_alerts\":{\"data\":{\"name\":\"\\u041d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0430\\u0442\\u043a\\u0438 \\u043f\\u043b\\u0430\\u0433\\u0438\\u043d\\u0430\"},\"rules\":[{\"name\":\"regex:\\/^callout$\\/mi\",\"props\":{\"variant\":[\"regex:\\/^danger|warning$\\/im\"]},\"errorCount\":false}],\"widgets\":[]},\"use_code\":{\"data\":{\"name\":\"\\u041a\\u043e\\u0434 \\u0434\\u043b\\u044f \\u043a\\u043e\\u043f\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f\"},\"rules\":[{\"name\":\"regex:\\/^copy_code$\\/mi\",\"errorCount\":false}],\"widgets\":[]}}', '2019-09-25 13:36:54', '2019-09-25 13:36:54'),
(13, 11, 'string', 'plugin_file', '/uploads/js-plugins/StartIsBack.zip', '2019-09-30 21:21:55', '2019-10-02 21:05:45'),
(14, 10, 'string', 'plugin_file', '/uploads/js-plugins/slick-slider.zip', '2019-10-02 21:22:53', '2019-11-07 18:22:18'),
(15, 11, 'string', 'plugin_site', 'https://owlcarousel2.github.io/OwlCarousel2/', '2019-10-03 22:23:10', '2019-10-03 22:23:10'),
(16, 11, 'string', 'plugin_github', 'https://github.com/OwlCarousel2/OwlCarousel2', '2019-10-03 22:23:10', '2019-10-03 22:23:10'),
(17, 11, 'string', 'plugin_npm', 'https://www.npmjs.com/package/owl.carousel', '2019-10-03 22:23:10', '2019-10-03 22:23:10'),
(18, 11, 'string', 'plugin_demo', 'https://owlcarousel2.github.io/OwlCarousel2/demos/demos.html', '2019-10-03 22:23:10', '2019-10-03 22:23:10'),
(19, 11, 'array', 'teaching', '[{\"title\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0435\\u043d\\u0438\\u0435 \\u043a\\u0430\\u0440\\u0443\\u0441\\u0435\\u043b\\u0438\",\"link\":\"https:\\/\\/www.youtube.com\\/watch?v=el0Dz3XSPMk\"},{\"title\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0435\\u043d\\u0438\\u0435 \\u043a\\u0430\\u0440\\u0443\\u0441\\u0435\\u043b\\u0438 \\u0442\\u0435\\u0441\\u0442\",\"link\":\"https:\\/\\/www.youtube.com\\/watch?v=el0Dz3XSPMk\"}]', '2019-10-04 20:17:00', '2019-10-04 22:34:03'),
(20, 10, 'string', 'plugin_site', 'https://kenwheeler.github.io/slick/', '2019-10-16 16:59:14', '2019-11-07 18:28:55'),
(21, 10, 'string', 'plugin_github', 'https://github.com/kenwheeler/slick/', '2019-10-16 16:59:14', '2019-11-07 18:28:55'),
(22, 10, 'string', 'plugin_npm', 'https://www.npmjs.com/package/slick-slider', '2019-10-16 16:59:15', '2019-11-07 18:28:55'),
(23, 10, 'string', 'plugin_demo', 'https://kenwheeler.github.io/slick/', '2019-10-16 16:59:15', '2019-11-07 18:28:55'),
(24, 7, 'string', 'plugin_file', '/uploads/js-plugins/StartIsBack.zip', '2019-10-17 11:08:54', '2019-10-17 11:08:54'),
(25, 7, 'string', 'plugin_site', 'https://owlcarousel2.github.io/OwlCarousel2/', '2019-10-17 11:08:54', '2019-10-17 11:08:54'),
(26, 7, 'string', 'plugin_github', 'https://github.com/OwlCarousel2/OwlCarousel2', '2019-10-17 11:08:54', '2019-10-17 11:08:54'),
(27, 7, 'string', 'plugin_npm', 'https://www.npmjs.com/package/owl.carousel', '2019-10-17 11:08:54', '2019-10-17 11:08:54'),
(28, 7, 'string', 'plugin_demo', 'https://owlcarousel2.github.io/OwlCarousel2/demos/demos.html', '2019-10-17 11:08:54', '2019-10-17 11:08:54'),
(29, 10, 'array', 'teaching', '[{\"title\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0435\\u043d\\u0438\\u0435 \\u043a\\u0430\\u0440\\u0443\\u0441\\u0435\\u043b\\u0438\",\"link\":\"https:\\/\\/www.youtube.com\\/watch?v=el0Dz3XSPMk\"},{\"title\":\"\\u041f\\u043e\\u0434\\u043a\\u043b\\u044e\\u0447\\u0435\\u043d\\u0438\\u0435 \\u043a\\u0430\\u0440\\u0443\\u0441\\u0435\\u043b\\u0438 \\u0442\\u0435\\u0441\\u0442\",\"link\":\"https:\\/\\/www.youtube.com\\/watch?v=el0Dz3XSPMk\"}]', '2019-11-07 18:48:42', '2019-11-07 18:48:42');

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(23, 'Плагины', 'plain-plugins', '2019-04-15 14:03:33', '2019-09-18 18:08:53'),
(28, 'Плагины2', 'plugins', '2019-09-17 05:41:35', '2019-09-17 05:41:35');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `type_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `menu_items`
--

INSERT INTO `menu_items` (`id`, `slug`, `publish`, `order`, `created_at`, `updated_at`, `menu_id`, `parent_id`, `type_id`, `name`, `icon`, `class`) VALUES
(37, 'fgdfg', 1, 35, '2019-04-20 00:16:11', '2019-10-07 10:13:31', 28, 38, 1, '{\"ru\": \"fdgfdfgkk\"}', NULL, NULL),
(38, 'fdgdfgfg', 0, 34, '2019-04-24 21:17:59', '2019-10-07 10:13:31', 28, 42, 2, '{\"ru\": \"Материал\"}', NULL, NULL),
(39, 'bottom4854', 1, 29, '2019-04-27 17:26:34', '2019-09-15 12:49:08', 28, 42, 2, '{\"ru\": \"Материал 1\"}', NULL, NULL),
(40, 'hjfhfghg', 1, 33, '2019-05-07 09:32:28', '2019-09-15 12:49:08', 28, 41, 1, '{\"ru\": \"Простая ссылка 3\"}', NULL, NULL),
(41, 'hjfhfghg2', 1, 31, '2019-05-07 09:32:34', '2019-09-15 12:49:08', 28, 39, 1, '{\"ru\": \"Простая ссылка 2\"}', NULL, NULL),
(42, 'hjfhfghg23', 1, 26, '2019-05-07 09:32:39', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Простая ссылка 1\"}', NULL, NULL),
(43, 'fdggfdgrg', 1, 32, '2019-05-14 11:02:14', '2019-09-15 12:49:08', 28, 41, 3, '{\"ru\": \"Категория 1\"}', NULL, NULL),
(44, 'ddfgdfgdfg', 1, 30, '2019-05-16 13:17:07', '2019-09-15 12:49:08', 28, 39, 3, '{\"ru\": \"Категория 2\"}', NULL, NULL),
(45, 'dfsdfsdfsdf', 1, 27, '2019-05-16 14:22:58', '2019-09-15 12:49:08', 28, 42, 2, '{\"ru\": \"Простой\"}', NULL, NULL),
(49, 'sdfsdfsdf', 1, 28, '2019-05-17 11:16:33', '2019-09-15 12:49:08', 28, 45, 1, '{\"ru\": \"Ссылка 5\"}', NULL, NULL),
(50, 'dsfsdfsdf', 1, 25, '2019-05-17 19:19:34', '2019-09-15 12:49:08', 28, 51, 1, '{\"ru\": \"Ссылка 6\"}', NULL, NULL),
(51, 'dsfsdfsdf2', 1, 24, '2019-05-17 19:19:58', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 7\"}', NULL, NULL),
(52, 'dfjsdlfj8', 1, 23, '2019-05-18 04:51:48', '2019-09-15 12:49:08', 28, 53, 1, '{\"ru\": \"Ссылка 8\"}', NULL, NULL),
(53, 'dfjsdlfj9', 1, 22, '2019-05-18 04:51:52', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 9\"}', NULL, NULL),
(54, 'dfjsdlfj10', 1, 21, '2019-05-18 04:51:57', '2019-09-15 12:49:08', 28, 55, 1, '{\"ru\": \"Ссылка 10\"}', NULL, NULL),
(55, 'dfjsdlfj11', 1, 20, '2019-05-18 04:52:03', '2019-09-15 12:49:08', 28, 56, 1, '{\"ru\": \"Ссылка 11\"}', NULL, NULL),
(56, 'dfjsdlfj12', 1, 19, '2019-05-18 04:52:05', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 12\"}', NULL, NULL),
(57, 'dfjsdlfj13', 1, 18, '2019-05-18 04:52:08', '2019-09-15 12:49:08', 28, 58, 1, '{\"ru\": \"Ссылка 13\"}', NULL, NULL),
(58, 'dfjsdlfj14', 1, 17, '2019-05-18 04:52:12', '2019-09-15 12:49:08', 28, 59, 1, '{\"ru\": \"Ссылка 14\"}', NULL, NULL),
(59, 'dfjsdlfj15', 1, 16, '2019-05-18 04:52:15', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 15\"}', NULL, NULL),
(60, 'dfjsdlfj16', 1, 15, '2019-05-18 04:52:24', '2019-09-15 12:49:08', 28, 61, 1, '{\"ru\": \"Ссылка 16\"}', NULL, NULL),
(61, 'dfjsdlfj17', 1, 14, '2019-05-18 04:52:28', '2019-09-15 12:49:08', 28, 62, 1, '{\"ru\": \"Ссылка 17\"}', NULL, NULL),
(62, 'dfjsdlfj18', 1, 13, '2019-05-18 04:52:31', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 18\"}', NULL, NULL),
(63, 'dfjsdlfj19', 1, 12, '2019-05-18 04:52:35', '2019-09-15 12:49:08', 28, 64, 1, '{\"ru\": \"Ссылка 19\"}', NULL, NULL),
(64, 'dfjsdlfj20', 1, 11, '2019-05-18 04:52:40', '2019-09-15 12:49:08', 28, 65, 1, '{\"ru\": \"Ссылка 20\"}', NULL, NULL),
(65, 'dfjsdlfj21', 1, 10, '2019-05-18 04:52:44', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 21\"}', NULL, NULL),
(66, 'dfjsdlfj22', 1, 9, '2019-05-18 04:52:48', '2019-09-15 12:49:08', 28, 67, 1, '{\"ru\": \"Ссылка 22\"}', NULL, NULL),
(67, 'dfjsdlfj23', 1, 8, '2019-05-18 04:52:52', '2019-09-15 12:49:08', 28, 68, 1, '{\"ru\": \"Ссылка 23\"}', NULL, NULL),
(68, 'dfjsdlfj24', 1, 7, '2019-05-18 04:52:55', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 24\"}', NULL, NULL),
(69, 'dfjsdlfj25', 1, 6, '2019-05-18 04:52:58', '2019-09-16 14:38:47', 28, 70, 1, '{\"ru\": \"Ссылка 25\"}', NULL, NULL),
(70, 'dfjsdlfj26', 1, 5, '2019-05-18 04:53:02', '2019-09-15 12:49:08', 28, 71, 1, '{\"ru\": \"Ссылка 26\"}', NULL, NULL),
(71, 'dfjsdlfj27', 1, 4, '2019-05-18 04:53:13', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 27\"}', NULL, NULL),
(72, 'dfjsdlfj28', 1, 3, '2019-05-18 04:53:17', '2019-09-15 12:49:08', 28, 74, 1, '{\"ru\": \"Ссылка 28\"}', NULL, NULL),
(73, 'dfjsdlfj29', 1, 2, '2019-05-18 04:53:20', '2019-09-15 12:49:08', 28, 74, 1, '{\"ru\": \"Ссылка 29\"}', NULL, NULL),
(74, 'dfjsdlfj30', 1, 1, '2019-05-18 04:53:26', '2019-09-15 12:49:08', 28, NULL, 1, '{\"ru\": \"Ссылка 30\"}', NULL, NULL),
(75, 'no-nesteed', 1, 36, '2019-09-15 12:47:55', '2019-10-07 10:13:42', 28, NULL, 1, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442 \\u0431\\u0435\\u0437 \\u0432\\u043b\\u043e\\u0436\\u0435\\u043d\\u043d\\u044b\\u0445\"}', NULL, NULL),
(104, 'slick-slider', 1, 2, '2019-09-22 14:31:52', '2019-11-19 20:37:39', 23, 158, 2, '{\"ru\":\"Slick Slider\"}', '/uploads/images/slick-slider_1569341720.png', NULL),
(105, 'owl-carousel', 1, 3, '2019-09-22 14:32:16', '2019-12-07 13:39:48', 23, 158, 2, '{\"ru\":\"Owl Carousel\"}', '/uploads/images/owl-carousel_1569343514.png', NULL),
(132, 'test1', 1, 17, '2019-09-25 13:27:49', '2019-12-07 13:39:48', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test1_1569428869.png', NULL),
(133, 'test2', 1, 18, '2019-09-25 13:28:09', '2019-12-07 13:39:48', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test2_1569428889.png', NULL),
(134, 'test3', 1, 20, '2019-09-25 13:28:13', '2019-12-07 13:39:48', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test3_1569428893.png', NULL),
(135, 'test4', 1, 23, '2019-09-25 13:28:16', '2019-12-07 13:43:21', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test4_1569494282.png', NULL),
(136, 'test5', 1, 24, '2019-09-25 13:28:20', '2019-12-07 13:43:21', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test5_1569428900.png', NULL),
(137, 'test6', 1, 25, '2019-09-25 13:28:35', '2019-12-07 13:40:36', 23, 136, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test6_1569428915.png', NULL),
(138, 'test7', 1, 21, '2019-09-25 13:28:38', '2019-12-07 13:43:19', 23, 134, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test7_1569428918.png', NULL),
(139, 'test8', 1, 22, '2019-09-25 13:28:40', '2019-12-07 13:43:21', 23, 134, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test8_1569428920.png', NULL),
(140, 'test9', 1, 28, '2019-09-25 13:28:44', '2019-12-07 13:40:36', 23, NULL, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test9_1569428924.png', 'null'),
(141, 'test10', 1, 6, '2019-09-25 13:28:49', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test10_1569428929.png', NULL),
(142, 'test11', 1, 16, '2019-09-25 13:28:52', '2019-12-07 13:39:49', 23, 158, 2, '{\"ru\":\"JQuery UI\"}', NULL, NULL),
(143, 'test12', 1, 5, '2019-09-25 13:28:55', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test12_1569428934.png', NULL),
(144, 'test13', 1, 19, '2019-09-25 13:28:58', '2019-12-07 13:39:49', 23, 158, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test13_1569428938.png', NULL),
(145, 'test14', 1, 4, '2019-09-25 13:29:01', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', '/uploads/images/test14_1569428941.png', NULL),
(147, 'services', 1, 38, '2019-10-07 10:01:28', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u0421\\u0435\\u0440\\u0432\\u0438\\u0441\\u044b\"}', NULL, NULL),
(148, 'hard-plugins', 1, 37, '2019-10-07 10:02:46', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u0425\\u0430\\u0440\\u0434 \\u043f\\u043b\\u0430\\u0433\\u0438\\u043d\\u044b\"}', NULL, NULL),
(149, 'algorithmics', 1, 36, '2019-10-07 10:03:04', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u0410\\u043b\\u0433\\u043e\\u0440\\u0438\\u0442\\u043c\\u0438\\u043a\\u0430\"}', NULL, NULL),
(150, 'techniques', 1, 35, '2019-10-07 10:03:29', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u041c\\u0435\\u0442\\u043e\\u0434\\u0438\\u043a\\u0438 \\u043f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f\"}', NULL, NULL),
(151, 'patterns', 1, 34, '2019-10-07 10:03:49', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u041f\\u0430\\u0442\\u0442\\u0435\\u0440\\u043d\\u044b \\u043f\\u0440\\u043e\\u0435\\u043a\\u0442\\u0438\\u0440. \\u0438 \\u041e\\u041e\\u041f\"}', NULL, NULL),
(152, 'ai', 1, 33, '2019-10-07 10:04:06', '2019-12-07 13:40:15', 23, NULL, 1, '{\"ru\":\"\\u0418\\u0418\"}', NULL, NULL),
(155, 'multimedia', 1, 29, '2019-10-07 10:07:25', '2019-12-07 13:40:36', 23, NULL, 1, '{\"ru\":\"\\u041c\\u0443\\u043b\\u044c\\u0442\\u0438\\u043c\\u0435\\u0434\\u0438\\u0430\"}', NULL, NULL),
(156, 'interface', 1, 27, '2019-10-07 10:07:38', '2019-12-07 13:40:36', 23, NULL, 1, '{\"ru\":\"\\u0418\\u043d\\u0442\\u0435\\u0440\\u0444\\u0435\\u0439\\u0441\"}', NULL, NULL),
(157, 'popups', 1, 26, '2019-10-07 10:07:54', '2019-12-07 13:40:36', 23, NULL, 1, '{\"ru\":\"\\u041f\\u043e\\u043f\\u0430\\u043f\\u044b\"}', NULL, NULL),
(158, 'sliders', 1, 1, '2019-10-07 10:13:50', '2019-11-19 20:37:41', 23, NULL, 1, '{\"ru\":\"\\u0421\\u043b\\u0430\\u0439\\u0434\\u0435\\u0440\\u044b\"}', NULL, NULL),
(159, 'test20', 1, 12, '2019-11-03 13:19:57', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(160, 'test21', 1, 15, '2019-11-03 13:20:15', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(161, 'test22', 1, 14, '2019-11-03 13:20:20', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(162, 'test23', 1, 13, '2019-11-03 13:20:24', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(163, 'test24', 1, 11, '2019-11-03 13:20:27', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(164, 'test25', 1, 10, '2019-11-03 13:20:30', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(165, 'test26', 1, 9, '2019-11-03 13:20:32', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(166, 'test27', 1, 8, '2019-11-03 13:20:36', '2019-12-07 13:39:49', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(167, 'test28', 1, 7, '2019-11-03 13:20:39', '2019-12-07 13:39:50', 23, 105, 2, '{\"ru\":\"\\u0422\\u0435\\u0441\\u0442\"}', NULL, NULL),
(168, 'graphics-css3', 1, 30, '2019-11-19 20:27:15', '2019-12-07 13:40:36', 23, NULL, 1, '{\"ru\":\"\\u0413\\u0440\\u0430\\u0444\\u0438\\u043a\\u0430 - CSS\"}', NULL, NULL),
(169, 'graphics-svg', 1, 31, '2019-11-19 20:28:51', '2019-12-07 13:40:36', 23, NULL, 1, '{\"ru\":\"\\u0413\\u0440\\u0430\\u0444\\u0438\\u043a\\u0430 - SVG\"}', NULL, NULL),
(170, 'graphics-canvas', 1, 32, '2019-11-19 20:29:40', '2019-12-07 13:40:16', 23, NULL, 1, '{\"ru\":\"\\u0413\\u0440\\u0430\\u0444\\u0438\\u043a\\u0430 - Canvas\"}', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_items_meta`
--

CREATE TABLE `menu_items_meta` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_item_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'null',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `menu_items_meta`
--

INSERT INTO `menu_items_meta` (`id`, `menu_item_id`, `type`, `key`, `value`, `created_at`, `updated_at`) VALUES
(33, 37, 'integer', 'is_router', '1', '2019-04-20 00:16:11', '2019-04-20 00:16:11'),
(34, 37, 'string', 'path', 'sdddddddddddddd33333k', '2019-04-20 11:27:13', '2019-04-20 11:28:24'),
(36, 38, 'string', 'content_type', 'js-plugin', '2019-04-24 21:17:59', '2019-04-24 21:17:59'),
(37, 38, 'string', 'material_slug', 'fggfgf23', '2019-04-24 21:17:59', '2019-04-24 21:40:11'),
(38, 39, 'string', 'content_type', 'js-plugin', '2019-04-27 17:26:34', '2019-04-27 17:26:34'),
(39, 39, 'string', 'material_slug', 'dsfdfsdf', '2019-04-27 17:26:34', '2019-05-16 14:33:20'),
(40, 40, 'integer', 'is_router', '1', '2019-05-07 09:32:28', '2019-05-07 09:32:28'),
(41, 40, 'string', 'path', 'fghfghgfh', '2019-05-07 09:32:28', '2019-05-07 09:32:28'),
(42, 41, 'integer', 'is_router', '1', '2019-05-07 09:32:34', '2019-05-07 09:32:34'),
(43, 41, 'string', 'path', 'fghfghgfh2', '2019-05-07 09:32:34', '2019-05-07 09:32:34'),
(44, 42, 'integer', 'is_router', '1', '2019-05-07 09:32:39', '2019-05-07 09:32:39'),
(45, 42, 'string', 'path', 'fghfghgfh23', '2019-05-07 09:32:39', '2019-05-07 09:32:39'),
(46, 43, 'string', 'category_slug', 'sdsdsdsd33333', '2019-05-14 11:02:14', '2019-05-14 11:02:30'),
(47, 44, 'string', 'category_slug', 'gdgdtdt', '2019-05-16 13:17:07', '2019-05-16 13:17:07'),
(48, 45, 'string', 'content_type', 'js-plugin', '2019-05-16 14:22:58', '2019-05-16 14:22:58'),
(49, 45, 'string', 'material_slug', 'bottomdd', '2019-05-16 14:22:58', '2019-05-16 14:24:12'),
(56, 49, 'integer', 'is_router', '1', '2019-05-17 11:16:33', '2019-05-17 11:16:33'),
(57, 49, 'string', 'path', 'dfgdfgfg', '2019-05-17 11:16:33', '2019-05-17 11:16:33'),
(58, 50, 'integer', 'is_router', '1', '2019-05-17 19:19:34', '2019-05-17 19:19:34'),
(59, 50, 'string', 'path', 'sdfsdfd', '2019-05-17 19:19:34', '2019-05-17 19:19:34'),
(60, 51, 'integer', 'is_router', '1', '2019-05-17 19:19:58', '2019-05-17 19:19:58'),
(61, 51, 'string', 'path', 'sdfsdfd2', '2019-05-17 19:19:58', '2019-05-17 19:19:58'),
(62, 52, 'integer', 'is_router', '1', '2019-05-18 04:51:48', '2019-05-18 04:51:48'),
(63, 52, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:51:48', '2019-05-18 04:51:48'),
(64, 53, 'integer', 'is_router', '1', '2019-05-18 04:51:52', '2019-05-18 04:51:52'),
(65, 53, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:51:52', '2019-05-18 04:51:52'),
(66, 54, 'integer', 'is_router', '1', '2019-05-18 04:51:57', '2019-05-18 04:51:57'),
(67, 54, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:51:57', '2019-05-18 04:51:57'),
(68, 55, 'integer', 'is_router', '1', '2019-05-18 04:52:03', '2019-05-18 04:52:03'),
(69, 55, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:03', '2019-05-18 04:52:03'),
(70, 56, 'integer', 'is_router', '1', '2019-05-18 04:52:05', '2019-05-18 04:52:05'),
(71, 56, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:05', '2019-05-18 04:52:05'),
(72, 57, 'integer', 'is_router', '1', '2019-05-18 04:52:08', '2019-05-18 04:52:08'),
(73, 57, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:08', '2019-05-18 04:52:08'),
(74, 58, 'integer', 'is_router', '1', '2019-05-18 04:52:12', '2019-05-18 04:52:12'),
(75, 58, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:12', '2019-05-18 04:52:12'),
(76, 59, 'integer', 'is_router', '1', '2019-05-18 04:52:16', '2019-05-18 04:52:16'),
(77, 59, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:16', '2019-05-18 04:52:16'),
(78, 60, 'integer', 'is_router', '1', '2019-05-18 04:52:24', '2019-05-18 04:52:24'),
(79, 60, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:24', '2019-05-18 04:52:24'),
(80, 61, 'integer', 'is_router', '1', '2019-05-18 04:52:28', '2019-05-18 04:52:28'),
(81, 61, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:28', '2019-05-18 04:52:28'),
(82, 62, 'integer', 'is_router', '1', '2019-05-18 04:52:31', '2019-05-18 04:52:31'),
(83, 62, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:32', '2019-05-18 04:52:32'),
(84, 63, 'integer', 'is_router', '1', '2019-05-18 04:52:35', '2019-05-18 04:52:35'),
(85, 63, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:35', '2019-05-18 04:52:35'),
(86, 64, 'integer', 'is_router', '1', '2019-05-18 04:52:40', '2019-05-18 04:52:40'),
(87, 64, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:40', '2019-05-18 04:52:40'),
(88, 65, 'integer', 'is_router', '1', '2019-05-18 04:52:44', '2019-05-18 04:52:44'),
(89, 65, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:44', '2019-05-18 04:52:44'),
(90, 66, 'integer', 'is_router', '1', '2019-05-18 04:52:48', '2019-05-18 04:52:48'),
(91, 66, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:48', '2019-05-18 04:52:48'),
(92, 67, 'integer', 'is_router', '1', '2019-05-18 04:52:52', '2019-05-18 04:52:52'),
(93, 67, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:52', '2019-05-18 04:52:52'),
(94, 68, 'integer', 'is_router', '1', '2019-05-18 04:52:55', '2019-05-18 04:52:55'),
(95, 68, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:55', '2019-05-18 04:52:55'),
(96, 69, 'integer', 'is_router', '1', '2019-05-18 04:52:58', '2019-05-18 04:52:58'),
(97, 69, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:52:58', '2019-05-18 04:52:58'),
(98, 70, 'integer', 'is_router', '1', '2019-05-18 04:53:03', '2019-05-18 04:53:03'),
(99, 70, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:53:03', '2019-05-18 04:53:03'),
(100, 71, 'integer', 'is_router', '1', '2019-05-18 04:53:14', '2019-05-18 04:53:14'),
(101, 71, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:53:14', '2019-05-18 04:53:14'),
(102, 72, 'integer', 'is_router', '1', '2019-05-18 04:53:17', '2019-05-18 04:53:17'),
(103, 72, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:53:17', '2019-05-18 04:53:17'),
(104, 73, 'integer', 'is_router', '1', '2019-05-18 04:53:20', '2019-05-18 04:53:20'),
(105, 73, 'string', 'path', 'dfjsdlfj86', '2019-05-18 04:53:20', '2019-09-15 17:42:30'),
(106, 74, 'integer', 'is_router', '1', '2019-05-18 04:53:26', '2019-05-18 04:53:26'),
(107, 74, 'string', 'path', 'dfjsdlfj8', '2019-05-18 04:53:26', '2019-05-18 04:53:26'),
(108, 75, 'integer', 'is_router', '0', '2019-09-15 12:47:55', '2019-09-15 12:47:55'),
(109, 75, 'string', 'path', 'https://www.npmjs.com/package/vue-draggable-nested-tree#usage', '2019-09-15 12:47:55', '2019-09-15 12:47:55'),
(166, 104, 'string', 'content_type', 'js-plugin', '2019-09-22 14:31:52', '2019-09-22 14:31:52'),
(167, 104, 'string', 'material_slug', 'slick-slider', '2019-09-22 14:31:52', '2019-09-22 14:31:52'),
(168, 105, 'string', 'content_type', 'js-plugin', '2019-09-22 14:32:16', '2019-09-22 14:32:16'),
(169, 105, 'string', 'material_slug', 'owl-carousel', '2019-09-22 14:32:16', '2019-09-22 14:32:16'),
(222, 132, 'string', 'content_type', 'js-plugin', '2019-09-25 13:27:49', '2019-09-25 13:27:49'),
(223, 132, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:27:49', '2019-09-25 13:27:49'),
(224, 133, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:09', '2019-09-25 13:28:09'),
(225, 133, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:09', '2019-09-25 13:28:09'),
(226, 134, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:13', '2019-09-25 13:28:13'),
(227, 134, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:13', '2019-09-25 13:28:13'),
(228, 135, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:17', '2019-09-25 13:28:17'),
(229, 135, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:17', '2019-09-25 13:28:17'),
(230, 136, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:20', '2019-09-25 13:28:20'),
(231, 136, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:20', '2019-09-25 13:28:20'),
(232, 137, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:35', '2019-09-25 13:28:35'),
(233, 137, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:35', '2019-09-25 13:28:35'),
(234, 138, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:38', '2019-09-25 13:28:38'),
(235, 138, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:38', '2019-09-25 13:28:38'),
(236, 139, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:41', '2019-09-25 13:28:41'),
(237, 139, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:41', '2019-09-25 13:28:41'),
(238, 140, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:44', '2019-09-25 13:28:44'),
(239, 140, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:44', '2019-09-25 13:28:44'),
(240, 141, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:49', '2019-09-25 13:28:49'),
(241, 141, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:49', '2019-09-25 13:28:49'),
(242, 142, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:52', '2019-09-25 13:28:52'),
(243, 142, 'string', 'material_slug', 'sdfsdfsdf55f', '2019-09-25 13:28:52', '2019-10-17 11:08:19'),
(244, 143, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:55', '2019-09-25 13:28:55'),
(245, 143, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:55', '2019-09-25 13:28:55'),
(246, 144, 'string', 'content_type', 'js-plugin', '2019-09-25 13:28:58', '2019-09-25 13:28:58'),
(247, 144, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:28:58', '2019-09-25 13:28:58'),
(248, 145, 'string', 'content_type', 'js-plugin', '2019-09-25 13:29:01', '2019-09-25 13:29:01'),
(249, 145, 'string', 'material_slug', 'bottomdd', '2019-09-25 13:29:01', '2019-09-25 13:29:01'),
(252, 147, 'integer', 'is_router', '1', '2019-10-07 10:01:28', '2019-10-07 10:01:28'),
(253, 147, 'string', 'path', 'empty', '2019-10-07 10:01:28', '2019-10-07 10:01:28'),
(254, 148, 'integer', 'is_router', '1', '2019-10-07 10:02:46', '2019-10-07 10:02:46'),
(255, 148, 'string', 'path', 'empty', '2019-10-07 10:02:46', '2019-10-07 10:02:46'),
(256, 149, 'integer', 'is_router', '1', '2019-10-07 10:03:04', '2019-10-07 10:03:04'),
(257, 149, 'string', 'path', 'empty', '2019-10-07 10:03:04', '2019-10-07 10:03:04'),
(258, 150, 'integer', 'is_router', '1', '2019-10-07 10:03:29', '2019-10-07 10:03:29'),
(259, 150, 'string', 'path', 'empty', '2019-10-07 10:03:29', '2019-10-07 10:03:29'),
(260, 151, 'integer', 'is_router', '1', '2019-10-07 10:03:49', '2019-10-07 10:03:49'),
(261, 151, 'string', 'path', 'empty', '2019-10-07 10:03:49', '2019-10-07 10:03:49'),
(262, 152, 'integer', 'is_router', '1', '2019-10-07 10:04:06', '2019-10-07 10:04:06'),
(263, 152, 'string', 'path', 'empty', '2019-10-07 10:04:06', '2019-10-07 10:04:06'),
(268, 155, 'integer', 'is_router', '1', '2019-10-07 10:07:25', '2019-10-07 10:07:25'),
(269, 155, 'string', 'path', 'empty', '2019-10-07 10:07:25', '2019-10-07 10:07:25'),
(270, 156, 'integer', 'is_router', '1', '2019-10-07 10:07:38', '2019-10-07 10:07:38'),
(271, 156, 'string', 'path', 'empty', '2019-10-07 10:07:38', '2019-10-07 10:07:38'),
(272, 157, 'integer', 'is_router', '1', '2019-10-07 10:07:54', '2019-10-07 10:07:54'),
(273, 157, 'string', 'path', 'empty', '2019-10-07 10:07:54', '2019-10-07 10:07:54'),
(274, 158, 'integer', 'is_router', '1', '2019-10-07 10:13:50', '2019-10-07 10:13:50'),
(275, 158, 'string', 'path', 'empty', '2019-10-07 10:13:50', '2019-10-07 10:13:50'),
(276, 159, 'string', 'content_type', 'js-plugin', '2019-11-03 13:19:57', '2019-11-03 13:19:57'),
(277, 159, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:19:58', '2019-11-03 13:19:58'),
(278, 160, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:15', '2019-11-03 13:20:15'),
(279, 160, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:15', '2019-11-03 13:20:15'),
(280, 161, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:20', '2019-11-03 13:20:20'),
(281, 161, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:20', '2019-11-03 13:20:20'),
(282, 162, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:24', '2019-11-03 13:20:24'),
(283, 162, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:24', '2019-11-03 13:20:24'),
(284, 163, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:27', '2019-11-03 13:20:27'),
(285, 163, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:27', '2019-11-03 13:20:27'),
(286, 164, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:30', '2019-11-03 13:20:30'),
(287, 164, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:30', '2019-11-03 13:20:30'),
(288, 165, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:33', '2019-11-03 13:20:33'),
(289, 165, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:33', '2019-11-03 13:20:33'),
(290, 166, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:36', '2019-11-03 13:20:36'),
(291, 166, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:36', '2019-11-03 13:20:36'),
(292, 167, 'string', 'content_type', 'js-plugin', '2019-11-03 13:20:39', '2019-11-03 13:20:39'),
(293, 167, 'string', 'material_slug', 'bottomdd', '2019-11-03 13:20:39', '2019-11-03 13:20:39'),
(294, 168, 'integer', 'is_router', '1', '2019-11-19 20:27:16', '2019-11-19 20:27:16'),
(295, 168, 'string', 'path', 'empty', '2019-11-19 20:27:16', '2019-11-19 20:27:16'),
(296, 169, 'integer', 'is_router', '1', '2019-11-19 20:28:51', '2019-11-19 20:28:51'),
(297, 169, 'string', 'path', 'empty', '2019-11-19 20:28:51', '2019-11-19 20:28:51'),
(298, 170, 'integer', 'is_router', '1', '2019-11-19 20:29:40', '2019-11-19 20:29:40'),
(299, 170, 'string', 'path', 'empty', '2019-11-19 20:29:41', '2019-11-19 20:29:41');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2017_12_07_122845_create_oauth_providers_table', 1),
(7, '2016_07_31_172026_CretaeRolesTable', 2),
(8, '2016_07_31_172059_CretaePermissionsTable', 2),
(9, '2016_07_31_172158_CretaePermissionRoleTable', 2),
(10, '2016_07_31_172243_CretaeRoleUserTable', 2),
(11, '2018_12_15_221213_add_immunity_roles_table', 3),
(12, '2017_03_04_000000_create_bans_table', 4),
(13, '2018_12_15_224443_add_banned_at_column_to_users_table', 5),
(14, '2019_02_24_160726_create_menus_table', 6),
(15, '2019_02_24_204710_create_menu_items_table', 6),
(16, '2019_02_24_213313_create_menu_items_metadata_table', 7),
(17, '2019_02_24_230033_change_menu_items_table', 8),
(18, '2019_02_27_172543_change_menu_items_table', 9),
(19, '2019_02_28_145353_create_menu_items_meta_table', 10),
(20, '2019_03_12_010905_change_menu_items_table3', 11),
(21, '2019_03_22_003521_create_menu_items_meta_en_table', 12),
(22, '2019_03_26_025014_create_categories_table', 13),
(23, '2019_03_26_031429_create_content_j_s_plugins_table', 14),
(24, '2019_03_28_165239_create_content_j_s_plugins_meta_table', 15),
(25, '2019_04_01_224351_change_menu_items_table4', 16),
(26, '2019_04_01_230739_change_menu_items_table5', 17),
(27, '2019_04_03_152759_create_tags_table', 18),
(28, '2019_04_10_132133_create_categoryable_table', 19),
(29, '2019_04_12_155120_create_tagable_table', 20),
(30, '2019_04_20_132454_change_menu_items_table6', 21),
(31, '2019_09_21_091539_change_menu_items_table7', 22);

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_providers`
--

CREATE TABLE `oauth_providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_providers`
--

INSERT INTO `oauth_providers` (`id`, `user_id`, `provider`, `provider_user_id`, `access_token`, `refresh_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'github', '5640787', 'ffd8ef303b90caf67b247877a18165123e2f4066', NULL, '2018-11-02 10:35:17', '2018-11-08 12:22:37');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('robingoode@mail.ru', '$2y$10$eyzAVICcY/0hqIaYDa5oHeFeeLnWdLEfg.6bQC9/OL7SJWRxhxqzq', '2018-11-04 11:53:31');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'EDIT_USERS', NULL, NULL),
(2, 'EDIT_MENU', NULL, NULL),
(3, 'EDIT_PERMISSIONS', NULL, NULL),
(4, 'EDIT_JS_PLUGIN', NULL, NULL),
(5, 'EDIT_JS_PLUGIN_ONLY_MY', NULL, NULL),
(6, 'EDIT_TAXONOMY', '2019-04-02 21:00:00', '2019-04-02 21:00:00'),
(7, 'EDIT_CATEGORIES', '2019-04-02 21:00:00', '2019-04-02 21:00:00'),
(8, 'EDIT_TAGS', '2019-04-02 21:00:00', '2019-04-02 21:00:00'),
(9, 'EDIT_TAXONOMY_ONLY_MY', '2019-04-02 21:00:00', '2019-04-02 21:00:00'),
(10, 'EDIT_CATEGORIES_ONLY_MY', '2019-04-02 21:00:00', '2019-04-02 21:00:00'),
(11, 'EDIT_TAGS_ONLY_MY', '2019-04-02 21:00:00', '2019-04-02 21:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `permission_role`
--

INSERT INTO `permission_role` (`id`, `created_at`, `updated_at`, `role_id`, `permission_id`) VALUES
(1, NULL, NULL, 1, 1),
(2, NULL, NULL, 2, 2),
(3, NULL, NULL, 1, 2),
(4, NULL, NULL, 2, 1),
(23, NULL, NULL, 1, 3),
(24, NULL, NULL, 3, 2),
(25, NULL, NULL, 1, 4),
(26, NULL, NULL, 1, 6),
(27, NULL, NULL, 1, 7),
(28, NULL, NULL, 1, 8),
(29, NULL, NULL, 2, 4),
(30, NULL, NULL, 4, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `immunity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`, `immunity`) VALUES
(1, 'superadmin', NULL, '2019-02-23 14:08:32', 100),
(2, 'admin', NULL, '2019-02-21 13:57:35', 80),
(3, 'moderator', NULL, NULL, 70),
(4, 'author', NULL, NULL, 60),
(5, 'vip', NULL, NULL, 50),
(6, 'vip silver', NULL, NULL, 50),
(7, 'vip gold', NULL, NULL, 50),
(8, 'vip platinum 33', NULL, '2019-02-21 13:50:59', 55),
(9, 'vip platinum 2', NULL, NULL, 50),
(10, 'vip platinum 3', NULL, NULL, 50),
(11, 'vip platinum 4', NULL, NULL, 50),
(12, 'vip platinum 5', NULL, NULL, 50),
(13, 'vip platinum 6', NULL, NULL, 50),
(14, 'vip platinum 7', NULL, NULL, 50),
(15, 'dddd', '2019-02-20 09:15:30', '2019-02-20 09:15:30', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_user`
--

INSERT INTO `role_user` (`id`, `created_at`, `updated_at`, `user_id`, `role_id`) VALUES
(1, NULL, NULL, 2, 1),
(2, NULL, NULL, 2, 2),
(12, NULL, NULL, 27, 2),
(13, NULL, NULL, 27, 3),
(19, NULL, NULL, 27, 5),
(20, NULL, NULL, 42, 5),
(21, NULL, NULL, 43, 4),
(24, NULL, NULL, 44, 5),
(25, NULL, NULL, 45, 4),
(26, NULL, NULL, 46, 4),
(27, NULL, NULL, 47, 4),
(28, NULL, NULL, 48, 4),
(29, NULL, NULL, 49, 5),
(30, NULL, NULL, 50, 4),
(31, NULL, NULL, 51, 4),
(37, NULL, NULL, 52, 4),
(39, NULL, NULL, 53, 4),
(40, NULL, NULL, 54, 3),
(41, NULL, NULL, 55, 3),
(42, NULL, NULL, 56, 4),
(44, NULL, NULL, 24, 5),
(54, NULL, NULL, 34, 4),
(57, NULL, NULL, 28, 2),
(58, NULL, NULL, 35, 2),
(59, NULL, NULL, 57, 2),
(60, NULL, NULL, 35, 3),
(63, NULL, NULL, 39, 2),
(65, NULL, NULL, 1, 4),
(66, NULL, NULL, 38, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tagables`
--

CREATE TABLE `tagables` (
  `tag_id` int(11) NOT NULL,
  `tagable_id` int(11) NOT NULL,
  `tagable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tagables`
--

INSERT INTO `tagables` (`tag_id`, `tagable_id`, `tagable_type`) VALUES
(2, 9, 'App\\ContentJSPlugin');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `banned_at`) VALUES
(1, 'Jeka2', 'robingoode2@mail.ru', NULL, '$2y$10$.SlQkMcLmQpW6Ihy/QcH5.JbEW9Km/udc3vWilVAyPAcueLITMgia', NULL, '2018-11-02 10:35:17', '2019-02-24 00:54:03', NULL),
(2, 'Jeka', 'robingoode@mail.ru', '2018-11-05 12:53:32', '$2y$10$.BYPpvLMQyC6U2.XLESwIOZZhpkLljXskPx88LETzYHX5.hREHwoa', NULL, '2018-11-03 15:28:58', '2018-11-05 12:53:32', NULL),
(24, 'Jeka', 'robingoode13@mail.ru', '2019-01-30 14:32:38', '$2y$10$KNEZGcazW4OyxQSrgJsEO.AIEoWJjZw8MhulkpBak/q0LyK7lEEKO', NULL, '2018-11-07 20:05:32', '2019-01-30 14:32:38', '2018-12-30 03:39:22'),
(27, 'Jeka99', 'robingoode16553@mail.ru', NULL, NULL, NULL, '2018-11-07 22:07:07', '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(28, 'Jeka', 'robingoode17@mail.ru', NULL, NULL, NULL, '2018-11-07 22:10:20', '2018-12-15 22:35:00', '2018-12-15 22:35:00'),
(33, 'Jeka', 'robingoode22@mail.ru', NULL, NULL, NULL, '2018-11-07 22:19:56', '2018-12-29 02:52:05', '2018-12-29 02:52:05'),
(34, 'Jeka', 'robingoode23@mail.ru', NULL, NULL, NULL, '2018-11-07 22:21:01', '2018-12-29 02:52:21', '2018-12-29 02:52:21'),
(35, 'Jeka', 'robingoode24@mail.ru', '2018-11-07 22:22:39', NULL, NULL, '2018-11-07 22:22:23', '2019-05-21 19:27:10', '2019-05-21 19:27:10'),
(38, 'Jeka', 'robingoode105@mail.ru', '2018-11-08 13:19:08', NULL, NULL, '2018-11-08 13:19:00', '2019-02-24 00:35:13', NULL),
(39, 'Jeka', 'robingoode106@mail.ru', '2018-11-08 13:19:57', NULL, NULL, '2018-11-08 13:19:42', '2019-02-24 00:29:56', NULL),
(40, 'Jeka234', 'robingoode1022@mail.ru', '2018-11-08 22:07:15', '$2y$10$hdFsXl42ezOsEktcUyUXGe188BJDlz25ZZH2VzUE3maKV0eyHnG5m', NULL, '2018-11-08 13:50:17', '2018-11-08 22:07:25', NULL),
(41, 'Jeka', 'robingood11@mail.ru', NULL, '$2y$10$9e6.XWcgVYODLWvMOXja6OcxtpQ8yMzFnVuozUDvkzDobL6GtPXGy', NULL, '2018-12-04 09:49:20', '2019-01-25 08:15:40', NULL),
(42, 'Jeka', 'robingoode1515@mail.ru', NULL, '$2y$10$8GRmIdFbm4hekrcKd4AP2eL85P94CPoEix5BJgIXNgtnfHEfRybQG', NULL, '2018-12-09 21:29:35', '2019-01-25 08:18:55', NULL),
(43, 'Jeka', 'robingoode1616@mail.ru', '2018-12-09 21:33:26', '$2y$10$hZp97pXECvRjVM58EVas1uMRWY6DsLNrBgxQ1yRHpmgBTIyREjOmC', NULL, '2018-12-09 21:30:58', '2019-01-24 16:39:12', '2019-01-24 16:39:12'),
(44, 'Jeka', 'robingoode5656@mail.ru', NULL, '$2y$10$istEwwQl4AI3KCH9CXDiueadYKBCJJoeeKJLBKp7x4RFqJ0T4d1xu', NULL, '2018-12-13 08:07:02', '2019-01-25 08:20:26', NULL),
(45, 'Jeka', 'robingoode777@mail.ru', NULL, '$2y$10$OdiYc4lH.xq6WKoYyrQOoOmRCuBZmH.MV72LVWDIPGX3HHqY3NYiu', NULL, '2018-12-13 09:21:52', '2019-01-24 16:39:39', '2019-01-24 16:39:39'),
(46, 'Jeka', 'robingoode4545@mail.ru', NULL, '$2y$10$cU7W5fv7HVD7eefeTx3w2OHMsvU7to1Tu7007rdT/SEsUCjD335CS', NULL, '2018-12-13 10:34:31', '2019-01-24 16:39:39', '2019-01-24 16:39:39'),
(47, 'Jeka', 'robingoode999@mail.ru', NULL, '$2y$10$JpOtPx3nlUeVFnHdpHlV5uB5/qn7nX8TrmabzhhUiWqSI.6EhDfBu', NULL, '2018-12-13 10:38:38', '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(48, 'Jeka', 'robingoode888@mail.ru', NULL, '$2y$10$tTxZfCZ1ol2/gWpwsSnJVeJVE7KgTnYWUMnCrAxrATD2o5.a0C4H2', NULL, '2018-12-13 10:39:36', '2019-01-24 16:43:15', '2019-01-24 16:43:15'),
(49, 'Jeka', 'robingoode455@mail.ru', NULL, '$2y$10$m4q1Zw7xp4t5OJM/d8YVhe2fZJXhy9in6RVZanABrsdJpv9XLTz0m', NULL, '2018-12-13 14:26:30', '2018-12-13 14:26:30', NULL),
(50, 'Jeka', 'robingoode111@mail.ru', NULL, '$2y$10$nSIKX5e57JnPk6z9eXRoiue9GcT4kKIYqBNA7NPWHBxriv4RIQZtm', NULL, '2018-12-13 14:38:18', '2018-12-13 14:38:18', NULL),
(51, 'Jeka', 'robingoode599@mail.ru', NULL, '$2y$10$HWLSVUJJTmOthoF57v1w6u.WrYZ8Me5K7AI5QibUefMlPcxnmnXAC', NULL, '2018-12-13 14:40:28', '2018-12-13 14:40:28', NULL),
(52, 'Jeka', 'robingoode122@mail.ru', NULL, '$2y$10$MtBxJjB3d200zX/CAbkbyOUlX1YypOjHjuzOGI0smXxlpLmIRC3Yi', NULL, '2018-12-13 15:52:56', '2018-12-13 15:52:56', NULL),
(53, 'Jeka', 'robingoode333@mail.ru', NULL, '$2y$10$Whoj9U6H2yYOQcre5IXk2utdJAKmYIa.tq8OUQRbVVGI/ySY8JOky', NULL, '2018-12-13 16:04:52', '2018-12-13 16:04:52', NULL),
(54, 'Jeka', 'robingoode444@mail.ru', NULL, '$2y$10$fUlKsS2zA8EhyhfsNCWZJuCBtvPyS3kNqZ0KzSqLAew5DlyslS2IK', NULL, '2018-12-13 16:05:28', '2018-12-13 16:05:28', NULL),
(55, 'Jeka', 'robingoode45555@mail.ru', NULL, '$2y$10$hXPJHRZ22tXjzaEnDmqEluUhqioxDZ2FAPbV9RdMGANjDp.ds49ni', NULL, '2018-12-13 16:06:22', '2018-12-13 16:06:22', NULL),
(56, 'Jeka', 'robingoode56946456@mail.ru', NULL, '$2y$10$C42RlE.2h65R3jSf65d7tuRtLtqJCpDa5wUAXj8VYGsg7Wbbla/hC', NULL, '2018-12-13 16:06:45', '2018-12-13 16:06:45', NULL),
(57, 'Jeka', 'robingoode1212@mail.ru', '2019-01-03 08:03:06', '$2y$10$xzoAGvWK/ZEZKX8hBipkNOgKhsoKJktBWHG56tB8Q/gasgIon00Va', NULL, '2019-01-03 07:59:30', '2019-01-03 08:03:06', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bans_bannable_type_bannable_id_index` (`bannable_type`,`bannable_id`),
  ADD KEY `bans_created_by_type_created_by_id_index` (`created_by_type`,`created_by_id`),
  ADD KEY `bans_expired_at_index` (`expired_at`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Индексы таблицы `content_j_s_plugins`
--
ALTER TABLE `content_j_s_plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_j_s_plugins_slug_unique` (`slug`);

--
-- Индексы таблицы `content_j_s_plugins_meta`
--
ALTER TABLE `content_j_s_plugins_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_j_s_plugins_meta_plugin_id_index` (`plugin_id`),
  ADD KEY `content_j_s_plugins_meta_key_index` (`key`);

--
-- Индексы таблицы `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_slug_unique` (`slug`);

--
-- Индексы таблицы `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_items_slug_unique` (`slug`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_items_parent_id_foreign` (`parent_id`);

--
-- Индексы таблицы `menu_items_meta`
--
ALTER TABLE `menu_items_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_meta_menu_item_id_index` (`menu_item_id`),
  ADD KEY `menu_items_meta_key_index` (`key`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_providers`
--
ALTER TABLE `oauth_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_providers_user_id_foreign` (`user_id`),
  ADD KEY `oauth_providers_provider_user_id_index` (`provider_user_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `content_j_s_plugins`
--
ALTER TABLE `content_j_s_plugins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `content_j_s_plugins_meta`
--
ALTER TABLE `content_j_s_plugins_meta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT для таблицы `menu_items_meta`
--
ALTER TABLE `menu_items_meta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `oauth_providers`
--
ALTER TABLE `oauth_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `content_j_s_plugins_meta`
--
ALTER TABLE `content_j_s_plugins_meta`
  ADD CONSTRAINT `content_j_s_plugins_meta_plugin_id_foreign` FOREIGN KEY (`plugin_id`) REFERENCES `content_j_s_plugins` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`);

--
-- Ограничения внешнего ключа таблицы `menu_items_meta`
--
ALTER TABLE `menu_items_meta`
  ADD CONSTRAINT `menu_items_meta_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `oauth_providers`
--
ALTER TABLE `oauth_providers`
  ADD CONSTRAINT `oauth_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Ограничения внешнего ключа таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
