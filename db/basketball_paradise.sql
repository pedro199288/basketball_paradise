-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-01-2020 a las 11:25:41
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.3.9

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
-- Estructura de tabla para la tabla `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_dni` varchar(9) NOT NULL,
  `address_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `location` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `addresses`
--

INSERT INTO `addresses` (`id`, `user_dni`, `address_number`, `name`, `surname`, `address`, `postal_code`, `location`, `province`, `deleted`) VALUES
(1, '12345678c', 1, 'Pedroa', 'JIméneze', '54a', 'dfa', 'dfaa', 'afa', 0),
(2, '12345678c', 2, 'Pedro', 'JIménez', '54', 'df', 'dfa', 'af', 0),
(3, '12345678c', 3, 'Pedro', 'JIménez', 'Dirección de prueba más larga para ver si se llena la tabla', 'df', 'dfa', 'af', 0),
(4, '12345678c', 4, 'Pedro', 'Monteagudo', 'una dirección', '32423', 'localidad', 'provincia', 0),
(5, '12345678a', 1, 'Administrador', 'El que administra', 'Casa del administrador', '00023', 'Admintown', 'Administralia', 0),
(6, '12345648r', 1, 'Nuevo', 'Nuevoes', 'Casa de nuevo', '23432', 'Casasimarro', 'Cuenca', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'id de la categoria a la que pertenece. NULL si es categoría padre; 0 si no tiene categoría',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_id`, `deleted`) VALUES
(2, 'Zapatillas', NULL, 0),
(3, 'Pantalones Cortos', NULL, 0),
(4, 'pantalones adidas', 3, 0),
(5, 'pantalones nike', 3, 0),
(6, 'pantalones nba', 3, 0),
(8, 'camisetas sin mangas', 0, 0),
(9, 'camisetas nba', 0, 0),
(10, 'zapatillas jordan', 2, 0),
(11, 'zapatillas Nike', 2, 0),
(12, 'Zapatillas Adidas', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `line_items`
--

CREATE TABLE `line_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `line_number` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `line_items`
--

INSERT INTO `line_items` (`id`, `order_id`, `line_number`, `product_id`, `price`, `quantity`) VALUES
(3, 9, 1, 17, 60, 1),
(4, 9, 2, 9, 68, 1),
(5, 10, 1, 17, 60, 1),
(6, 10, 2, 9, 68, 1),
(7, 11, 1, 17, 60, 1),
(8, 11, 2, 9, 68, 1),
(9, 12, 1, 14, 75, 2),
(10, 12, 2, 16, 35, 3),
(11, 12, 3, 7, 84, 2),
(12, 13, 1, 15, 85, 2),
(13, 13, 2, 7, 84, 3),
(14, 14, 1, 9, 68, 1),
(15, 14, 2, 17, 60, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_dni` varchar(9) NOT NULL,
  `address` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `shipping_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_dni`, `address`, `payment_method`, `status`, `purchase_date`, `shipping_date`, `delivery_date`) VALUES
(9, '12345678c', 2, 'paypal', 'realizado', '2020-01-05 12:14:56', NULL, NULL),
(10, '12345678c', 1, 'card', 'realizado', '2020-01-05 12:59:23', NULL, NULL),
(11, '12345678c', 1, 'card', 'realizado', '2020-01-05 01:02:31', NULL, NULL),
(12, '12345678c', 3, 'card', 'realizado', '2020-01-05 05:07:00', NULL, NULL),
(13, '12345678a', 5, 'paypal', 'realizado', '2020-01-05 11:15:28', NULL, NULL),
(14, '12345648r', 6, 'card', 'realizado', '2020-01-05 11:44:24', NULL, NULL);

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
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `categories`, `image`, `deleted`, `modified`) VALUES
(7, 'Zapatillas Kevin Durant', 'Zapatillas Kevin Durant negras ', 84, 10, '[\"11\"]', 'xnike-kd-trey-5-vii-gold-black-16.jpg.pagespeed.ic.6kaDUbECwk.webp', 0, '2020-01-06 11:38:26'),
(8, 'Camiseta Derrick Rose Chicago Bulls', 'dfa afd', 23, 23, '[\"8\",\"9\"]', 'derrick_rose_adidas_replica_jersey_ml.jpg', 0, '2019-12-22 19:04:39'),
(9, 'Camiseta Luca Doncic', 'Camiseta de manga corta de Luca Doncic en Dallas Mavericks', 68, 6, '[\"9\"]', '51OjKgHjOpL._UX679_.jpg', 0, '2020-01-06 11:38:34'),
(10, 'Camiseta Lebron James', 'Lebron James', 70, 23, '[\"8\",\"9\"]', 'lebron-james-association-edition-swingman-los-angeles-lakers.jpg', 0, '2019-12-22 19:04:45'),
(11, 'Pantalones Los Ángeles Lakers', 'Pantalones de juego de los Ángeles Lakers', 25, 10, '[\"5\",\"6\"]', 'f9gpphuqmhqg5x9zkvtp.webp', 0, '2020-01-06 11:54:53'),
(12, 'Camiseta de entrenamiento adidas', 'Una camiseta para entrenar', 20, 6, '[\"8\",\"9\"]', '', 0, '2019-12-22 19:04:50'),
(13, 'Zapatillas Nike Huarache', 'Unas zapatillas', 85, 3, '[\"11\"]', '', 0, '0000-00-00 00:00:00'),
(14, 'Zapatillas Jordan I', 'Zaptillas Jordan I en color rojo/negro', 75, 10, '[\"10\",\"11\"]', '001426671_101.png', 0, '0000-00-00 00:00:00'),
(15, 'Zaptillas Derrick Rose 5', 'Zapatillas Derrick Rose 5 en color negro, cordones rojos', 85, 30, '[\"12\"]', '81hBqsIPUfL._SX500._SX._UX._SY._UY_.jpg', 0, '0000-00-00 00:00:00'),
(16, 'Pantalones Boston Celtics', 'Pantalones de juego de los Boston Celtics', 35, 16, '[\"5\",\"6\"]', 'boston-celtics-statement-edition-swingman-shorts-junior.jpg', 0, '2020-01-06 12:14:24'),
(17, 'Camiseta Kobe Bryant', 'Camiseta Kobe Bryant Los Ángeles Lakers en color amarillo', 60, 23, '[\"8\",\"9\"]', 'bryant-lakers-24-niño-amarillo.jpg', 0, '2020-01-06 11:38:20');

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
('12345648r', 'Nuevo', 'Nuevo', 'nuevo@nuevo.com', '$2y$10$2IFIsTkju1KZuyw2iCpTn.ioNYMpYfItpEuO8o/JPX8kgCib21.za', 'cliente', 'activo'),
('12345648w', NULL, NULL, 'nuevo2@nuevo.com', '$2y$10$qWYYpsuOJe4ZMH0vp9D0Wufebc1oAJyQT7o0jKs/mkyeUQqoKGM5a', 'cliente', 'activo'),
('12345678a', 'admin', 'admin', 'admin@admin.com', '$2y$10$fg3.ZlKJuaF/EOdHal9dCu.UWVkEg.kepODosFDUujYfdrBsiR0FC', 'admin', 'activo'),
('12345678c', 'cliente', 'cliente', 'cliente@cliente.com', '$2y$10$qvamGve2Ykc.cuxMmX2JzOdFLbYLgCgSMFLwvgW22uj0blEN23Ucq', 'cliente', 'activo'),
('23408222e', NULL, NULL, 'empleado@empleado.com', '$2y$10$2B79G/RAms2bhG0SRl3.FeNSyAmwup3UlGQ970cHseQSVEftuJTZK', 'moderador', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_address` (`user_dni`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `line_items`
--
ALTER TABLE `line_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_dni` (`user_dni`),
  ADD KEY `order_address` (`address`);

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
-- AUTO_INCREMENT de la tabla `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `line_items`
--
ALTER TABLE `line_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `user_address` FOREIGN KEY (`user_dni`) REFERENCES `users` (`dni`);

--
-- Filtros para la tabla `line_items`
--
ALTER TABLE `line_items`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_address` FOREIGN KEY (`address`) REFERENCES `addresses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_dni` FOREIGN KEY (`user_dni`) REFERENCES `users` (`dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
