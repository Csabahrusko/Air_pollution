-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Nov 17. 13:43
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `air_pollution_db_cities`
--

CREATE TABLE `air_pollution_db_cities` (
  `Dat` datetime NOT NULL,
  `SO2` text NOT NULL,
  `NO2` text NOT NULL,
  `CO` text NOT NULL,
  `O3` text NOT NULL,
  `NOO` text NOT NULL,
  `PM10` text NOT NULL,
  `PM25` text NOT NULL,
  `City` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `air_pollution_db_cities`
--

INSERT INTO `air_pollution_db_cities` (`Dat`, `SO2`, `NO2`, `CO`, `O3`, `NOO`, `PM10`, `PM25`, `City`) VALUES
('2021-11-17 13:04:35', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:05:15', '8.82', '17.14', '270.37', '39.7', '4.41', '5.6', '2.93', 'London'),
('2021-11-17 13:06:14', '137.33', '106.93', '3738.4', '0', '243.19', '527.64', '362.02', 'peking'),
('2021-11-17 13:10:30', '8.82', '17.14', '270.37', '39.7', '4.41', '5.6', '2.93', 'London'),
('2021-11-17 13:11:51', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:12:19', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:14:30', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:15:07', '137.33', '106.93', '3738.4', '0', '243.19', '527.64', '362.02', 'Beijing'),
('2021-11-17 13:16:37', '2.12', '3.26', '280.38', '48.64', '0.09', '11.59', '9.2', 'Pákozd'),
('2021-11-17 13:20:36', '2.12', '3.26', '280.38', '48.64', '0.09', '11.59', '9.2', 'Pákozd'),
('2021-11-17 13:22:44', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:23:11', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:23:21', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:24:35', '11.44', '23.99', '387.19', '38.98', '2.65', '25.03', '21.14', 'budapest'),
('2021-11-17 13:27:06', '8.82', '17.14', '270.37', '39.7', '4.41', '5.6', '2.93', 'London'),
('2021-11-17 13:39:21', '9.42', '31.53', '427.25', '29.33', '4.25', '27.96', '23.47', 'Budapest'),
('2021-11-17 13:39:42', '2.86', '45.93', '1014.71', '0.48', '94.77', '46.24', '30.87', 'new york'),
('2021-11-17 13:40:06', '9.42', '31.53', '427.25', '29.33', '4.25', '27.96', '23.47', 'budapest'),
('2021-11-17 13:40:19', '154.5', '97.33', '3177.64', '0', '173.45', '467.95', '310.38', 'peking');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
