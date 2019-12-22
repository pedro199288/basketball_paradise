-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2019 a las 20:15:59
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `basketball_paradise`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'id de la categoria a la que pertenece. NULL si es categoría padre; 0 si no tiene categoría'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_id`) VALUES
(2, 'Zapatillas', NULL),
(3, 'Pantalones Cortos', NULL),
(4, 'pantalones adidas', 3),
(5, 'pantalones nike', 3),
(6, 'pantalones nba', 3),
(8, 'camisetas sin mangas', 0),
(9, 'camisetas nba', 0),
(10, 'zapatillas jordan', 2),
(11, 'zapatillas Nike', 2),
(12, 'Zapatillas Adidas', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `categories` text COMMENT 'guarda categorias en json',
  `image` varchar(100) DEFAULT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `categories`, `image`, `modified`) VALUES
(7, 'Zapatillas Kevin Durant', 'Zapatillas Kevin Durant negras ', 84, 10, '[\"11\"]', 'xnike-kd-trey-5-vii-gold-black-16.jpg.pagespeed.ic.6kaDUbECwk.webp', '2019-12-21 16:36:59'),
(8, 'Camiseta Derrick Rose Chicago Bulls', 'dfa afd', 23, 23, '[\"8\",\"9\"]', 'derrick_rose_adidas_replica_jersey_ml.jpg', '2019-12-22 19:04:39'),
(9, 'Camiseta Luca Doncic', 'Camiseta de manga corta de Luca Doncic en Dallas Mavericks', 68, 6, '[\"9\"]', '51OjKgHjOpL._UX679_.jpg', '2019-12-22 19:05:22'),
(10, 'Camiseta Lebron James', 'Lebron James', 70, 23, '[\"8\",\"9\"]', 'lebron-james-association-edition-swingman-los-angeles-lakers.jpg', '2019-12-22 19:04:45'),
(11, 'Pantalones Los Ángeles Lakers', 'Pantalones de juego de los Ángeles Lakers', 25, 10, '[\"6\"]', 'f9gpphuqmhqg5x9zkvtp.webp', '0000-00-00 00:00:00'),
(12, 'Camiseta de entrenamiento adidas', 'Una camiseta para entrenar', 20, 6, '[\"8\",\"9\"]', '', '2019-12-22 19:04:50'),
(13, 'Zapatillas Nike Huarache', 'Unas zapatillas', 85, 3, '[\"11\"]', '', '0000-00-00 00:00:00'),
(14, 'Zapatillas Jordan I', 'Zaptillas Jordan I en color rojo/negro', 75, 10, '[\"10\",\"11\"]', '001426671_101.png', '0000-00-00 00:00:00'),
(15, 'Zaptillas Derrick Rose 5', 'Zapatillas Derrick Rose 5 en color negro, cordones rojos', 85, 30, '[\"12\"]', '81hBqsIPUfL._SX500._SX._UX._SY._UY_.jpg', '0000-00-00 00:00:00'),
(16, 'Pantalones Boston Celtics', 'Pantalones de juego de los Boston Celtics', 35, 16, '[\"5\",\"6\"]', 'boston-celtics-statement-edition-swingman-shorts-junior.jpg', '0000-00-00 00:00:00'),
(17, 'Camiseta Kobe Bryant', 'Camiseta Kobe Bryant Los Ángeles Lakers en color amarillo', 60, 23, '[\"8\",\"9\"]', 'bryant-lakers-24-niño-amarillo.jpg', '2019-12-22 19:04:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `dni` varchar(9) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `rol` enum('admin','cliente','moderador','') NOT NULL DEFAULT 'cliente',
  `status` enum('activo','inactivo','borrado','') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`dni`, `name`, `surname`, `email`, `password`, `rol`, `status`) VALUES
('123456789', NULL, NULL, 'd@d.com', '$2y$10$WKjvLaciJPrrYjMedcBxHOdrWx.L1h0qNzAOpdh/XGBXruMeMicfi', 'cliente', 'activo'),
('12345678a', 'admin', 'admin', 'admin@admin.com', '$2y$10$fg3.ZlKJuaF/EOdHal9dCu.UWVkEg.kepODosFDUujYfdrBsiR0FC', 'admin', 'activo'),
('12345678c', NULL, NULL, 'cliente@cliente.com', '$2y$10$qvamGve2Ykc.cuxMmX2JzOdFLbYLgCgSMFLwvgW22uj0blEN23Ucq', 'cliente', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
