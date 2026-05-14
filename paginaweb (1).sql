-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2026 a las 21:03:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `paginaweb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `document_types`
--

INSERT INTO `document_types` (`id`, `name`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Pasaporte'),
(3, 'Cédula de Extranjería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`) VALUES
(1, 'Efectivo '),
(2, 'Trageta de credito'),
(3, 'Transferencia ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `people` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `room_id`, `payment_method_id`, `start_date`, `end_date`, `people`, `price`, `status_id`, `created_at`, `updated_at`) VALUES
(12, 2, 11, NULL, '2026-04-30', '2026-05-02', 3, 1080000.00, 6, '2026-04-30 14:23:30', '2026-04-30 14:24:00'),
(13, 3, 2, NULL, '2026-05-05', '2026-05-06', 2, 160000.00, 6, '2026-05-05 00:52:04', '2026-05-05 00:52:04'),
(14, 6, 1, NULL, '2026-05-08', '2026-05-09', 1, 80000.00, 7, '2026-05-08 19:20:43', '2026-05-08 19:58:08'),
(15, 6, 2, NULL, '2026-05-08', '2026-05-09', 1, 80000.00, 7, '2026-05-08 19:31:37', '2026-05-08 19:58:10'),
(16, 6, 12, NULL, '2026-05-08', '2026-05-09', 2, 360000.00, 7, '2026-05-08 19:49:42', '2026-05-14 13:41:47'),
(17, 6, 8, NULL, '2026-05-08', '2026-05-09', 1, 120000.00, 7, '2026-05-08 19:58:23', '2026-05-14 13:41:50'),
(18, 6, 6, NULL, '2026-05-08', '2026-05-09', 1, 120000.00, 7, '2026-05-08 20:02:08', '2026-05-14 13:41:52'),
(19, 6, 1, NULL, '2026-05-08', '2026-05-09', 2, 160000.00, 7, '2026-05-08 20:10:52', '2026-05-14 13:41:54'),
(20, 6, 2, NULL, '2026-05-14', '2026-05-16', 2, 320000.00, 7, '2026-05-14 03:12:07', '2026-05-14 13:41:56'),
(21, 6, 2, NULL, '2026-05-14', '2026-05-16', 2, 320000.00, 6, '2026-05-14 03:15:50', '2026-05-14 03:15:50'),
(22, 6, 2, NULL, '2026-05-14', '2026-05-16', 2, 320000.00, 6, '2026-05-14 03:16:47', '2026-05-14 03:16:47'),
(23, 6, 7, NULL, '2026-05-14', '2026-05-15', 2, 240000.00, 6, '2026-05-14 13:47:31', '2026-05-14 13:47:31'),
(24, 6, 12, NULL, '2026-05-14', '2026-05-15', 2, 360000.00, 6, '2026-05-14 14:05:42', '2026-05-14 14:05:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'client');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type_id` int(11) DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `max_people` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `beds`, `max_people`, `description`, `price`, `status_id`) VALUES
(1, '101', 1, 1, 2, 'Habitación estándar comoda', 80000.00, 1),
(2, '102', 1, 1, 2, 'Habitación estándar comoda', 80000.00, 1),
(3, '103', 1, 1, 2, 'Habitación estándar comoda', 80000.00, 1),
(4, '104', 1, 1, 2, 'Habitación estándar comoda', 80000.00, 1),
(5, '105', 1, 1, 2, 'Habitación estándar comoda', 80000.00, 1),
(6, '201', 2, 1, 2, 'Habitación plata con vista', 120000.00, 1),
(7, '202', 2, 1, 2, 'Habitación plata con vista', 120000.00, 1),
(8, '203', 2, 1, 2, 'Habitación plata con vista', 120000.00, 1),
(9, '204', 2, 1, 2, 'Habitación plata con vista', 120000.00, 1),
(10, '205', 2, 1, 2, 'Habitación plata con vista', 120000.00, 1),
(11, '301', 3, 2, 4, 'Habitación oro con 2 camas', 180000.00, 1),
(12, '302', 3, 2, 4, 'Habitación oro con 2 camas', 180000.00, 1),
(13, '303', 3, 2, 4, 'Habitación oro con 2 camas', 180000.00, 1),
(14, '304', 3, 2, 4, 'Habitación oro con 2 camas', 180000.00, 1),
(15, '305', 3, 2, 4, 'Habitación oro con 2 camas', 180000.00, 1),
(16, '401', 4, 2, 4, 'Habitación diamante con 2 camas y balcon con vista al mar', 250000.00, 1),
(17, '402', 4, 2, 4, 'Habitación diamante con 2 camas y balcon con vista al mar', 250000.00, 1),
(18, '403', 4, 2, 4, 'Habitación diamante con 2 camas y balcon con vista al mar', 250000.00, 1),
(19, '404', 4, 2, 4, 'Habitación diamante con 2 camas y balcon con vista al mar', 250000.00, 1),
(20, '405', 4, 2, 4, 'Habitación diamante con 2 camas y balcon con vista al mar', 250000.00, 1),
(21, '501', 5, 3, 6, 'Habitación platino con 3 camas y sala deestar con valco y 3 baños privados', 400000.00, 1),
(22, '502', 5, 3, 6, 'Habitación platino con 3 camas y sala deestar con valco y 3 baños privados', 400000.00, 1),
(23, '503', 5, 3, 6, 'Habitación platino con 3 camas y sala deestar con valco y 3 baños privados', 400000.00, 1),
(24, '504', 5, 3, 6, 'Habitación platino con 3 camas y sala deestar con valco y 3 baños privados', 400000.00, 1),
(25, '505', 5, 3, 6, 'Habitación platino con 3 camas y sala deestar con valco y 3 baños privados', 400000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `room_types`
--

CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `description`) VALUES
(1, 'Estandar', 'Habitación estándar cómoda.'),
(2, 'Plata', 'Habitación más amplia con baño incluido. '),
(3, 'Oro', 'Habitación con aire acondicionado y mayor capacidad.'),
(4, 'Diamante', 'Habitación con balcón, baño privado. '),
(5, 'Platino', 'Habitación con gran capacidad, con sala, dos baños privados ideal para familias.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`, `type`) VALUES
(1, 'active', 'user'),
(2, 'inactive', 'user'),
(3, 'available', 'room'),
(4, 'occupied', 'room'),
(5, 'pending', 'reservation'),
(6, 'confirmed', 'reservation'),
(7, 'cancelled', 'reservation');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_number` bigint(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `document_type_id`, `document_number`, `name`, `last_name`, `email`, `id_rol`, `state`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 1234567890, 'Daniel', 'Rocha', 'daniel@gmail.com', 0, '', '$2y$10$mDaMY5NmvKtHQU67RocOFeSZGPWcz5httWk4Z69aW0GOn9ad9SNzO', '2026-04-23 00:48:20', '2026-04-23 00:48:20'),
(2, 1, 123456, 'William ', 'Duarte', 'adsosenawd@gmail.com', 0, '', '$2y$10$rvtd0YuwDDce8H.5.mhWkOMcNl/cFgaRwyIayULNLVcUyaHP8YsWS', '2026-04-23 18:38:50', '2026-04-23 18:38:50'),
(3, 1, 1110501182, 'Fidel', 'Rocha ', 'danielestirochapuli8@gmail.com', 0, '', '$2y$10$SJu5fwc7is7Lg2NMLHZ8XezmPpeBV8gEfLaalUDiy3MRXbMej5bDO', '2026-05-05 00:51:00', '2026-05-05 00:51:00'),
(5, 1, 1110501189, 'Claudia', 'Rocha', 'claudiapulidonuevo@gmail.com', 0, '', '$2y$10$9Mhg4yIRrWuPM6jPXwXN1.2dpnZ0qU1jy/b/YbYfxcN9hP.LenwOq', '2026-05-05 01:35:31', '2026-05-05 01:35:31'),
(6, 1, 1110501180, 'Daniel', 'Rocha', 'danielpulidorocha2006@gmail.com', 0, '', '$2y$10$kC42hBigjIqDdQqhj.Hmp.7IdsC3Y2xy4b/xIeO8eXW8QoHIGu9o2', '2026-05-08 19:20:00', '2026-05-08 19:20:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indices de la tabla `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_type_id` (`document_type_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`),
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
