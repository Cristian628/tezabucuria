-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 22 2022 г., 21:54
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `teza`
--

DELIMITER $$
--
-- Функции
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Comanda_cantitate` (`NUMAR_COMANDA` DECIMAL(10,2)) RETURNS DECIMAL(10,4)  BEGIN
    DECLARE Comanda_cantitate  DECIMAL(10,2);
     IF NUMAR_COMANDA=1001  
 THEN
        SET Comanda_cantitate  = CANTITATE*2;
    ELSEIF  NUMAR_COMANDA=1003  
    THEN
        SET Comanda_cantitate  = CANTITATE*4;
    ELSEIF Comanda_cantitate=2002 
    THEN
        SET Comanda_cantitate  = 300;
    END IF;
    -- return the customer level
    RETURN (Comanda_cantitate );
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Comanda_cantitate_1` (`NUMAR_COMANDA` DECIMAL(10,2), `CANTITATE` DECIMAL(10,2)) RETURNS DECIMAL(10,4)  BEGIN
    DECLARE Comanda_cantitate_1 DECIMAL(10,2);
     IF NUMAR_COMANDA=1001  
 THEN
        SET Comanda_cantitate_1  = CANTITATE*2;
    ELSEIF  NUMAR_COMANDA=1003  
    THEN
        SET Comanda_cantitate_1  = CANTITATE*4;
    ELSEIF NUMAR_COMANDA=2002 
    THEN
        SET Comanda_cantitate_1  = 300;
    END IF;
    -- return the customer level
    RETURN (Comanda_cantitate_1 );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `cheltuieli`
--

CREATE TABLE `cheltuieli` (
  `id_cheltuieli` int(11) NOT NULL,
  `suma_cheltuieli` float DEFAULT NULL,
  `id_mat` int(11) DEFAULT NULL,
  `id_ang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cheltuieli`
--

INSERT INTO `cheltuieli` (`id_cheltuieli`, `suma_cheltuieli`, `id_mat`, `id_ang`) VALUES
(1, 2000, 1, 1),
(2, 4200, 2, 1),
(3, 3700, 3, 1),
(4, 6000, 4, 1),
(5, 5500, 5, 1),
(6, 4000, 6, 1),
(7, 3200, 7, 1),
(8, 2900, 8, 1),
(9, 1600, 9, 1),
(10, 500, 10, 1),
(11, 2400, 11, 1),
(12, 560, 12, 1);

--
-- Триггеры `cheltuieli`
--
DELIMITER $$
CREATE TRIGGER `trigger_cheltuieli` BEFORE UPDATE ON `cheltuieli` FOR EACH ROW IF NEW.suma_cheltuieli < 0
THEN SET NEW.suma_cheltuieli = 0; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `dateang`
--

CREATE TABLE `dateang` (
  `id_ang` int(11) NOT NULL,
  `nameang` varchar(20) DEFAULT NULL,
  `namepass` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `dateang`
--

INSERT INTO `dateang` (`id_ang`, `nameang`, `namepass`, `email`, `admin`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 1),
(2, 'user', 'lealea', 'user@gmail.com', 0),
(5, 'Emos', '1234', 'ggf@gmail.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `profit`
--

CREATE TABLE `profit` (
  `id_profit` int(11) NOT NULL,
  `suma_profit` float DEFAULT NULL,
  `id_mat` int(11) DEFAULT NULL,
  `id_ang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `profit`
--

INSERT INTO `profit` (`id_profit`, `suma_profit`, `id_mat`, `id_ang`) VALUES
(1, 5200, 1, 1),
(2, 1800, 2, 1),
(3, 2200, 3, 1),
(4, 1850, 4, 1),
(5, 1500, 5, 1),
(6, 1150, 6, 1),
(7, 1600, 7, 1),
(8, 2100, 8, 1),
(9, 1500, 9, 1),
(10, 700, 10, 1),
(11, 1200, 11, 1),
(12, 640, 12, 1);

--
-- Триггеры `profit`
--
DELIMITER $$
CREATE TRIGGER `update_profit` BEFORE UPDATE ON `profit` FOR EACH ROW IF NEW.suma_profit < 0
THEN SET NEW.suma_profit = 0; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `resmateriale`
--

CREATE TABLE `resmateriale` (
  `id_mat` int(11) NOT NULL,
  `namemater` varchar(20) DEFAULT NULL,
  `id_ang` int(11) DEFAULT NULL,
  `cantitatea` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `resmateriale`
--

INSERT INTO `resmateriale` (`id_mat`, `namemater`, `id_ang`, `cantitatea`) VALUES
(1, 'Bomboane', 1, 60),
(2, 'Caramela', 1, 80),
(3, 'Iris', 1, 88),
(4, 'Zefir', 1, 60),
(5, 'Jeleuri', 1, 60),
(6, 'Drajeuri', 1, 160),
(7, 'Napolitane', 1, 80),
(8, 'Biscuiți', 1, 180),
(9, 'Produse diabetice', 1, 80),
(10, 'Ciocolată', 1, 10),
(11, 'Sortiment de bomboan', 1, 60),
(12, 'Torturi', 1, 4);

--
-- Триггеры `resmateriale`
--
DELIMITER $$
CREATE TRIGGER `cantitateacheck` BEFORE INSERT ON `resmateriale` FOR EACH ROW IF NEW.cantitatea < 0
THEN SET NEW.cantitatea = 0; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `venit`
--

CREATE TABLE `venit` (
  `id_venit` int(11) NOT NULL,
  `id_mat` int(11) DEFAULT NULL,
  `suma_venit` float DEFAULT NULL,
  `id_ang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `venit`
--

INSERT INTO `venit` (`id_venit`, `id_mat`, `suma_venit`, `id_ang`) VALUES
(1, 1, 7200, 1),
(2, 2, 6000, 1),
(3, 3, 5900, 1),
(4, 4, 7850, 1),
(5, 5, 7000, 1),
(6, 6, 5150, 1),
(7, 7, 4800, 1),
(8, 8, 5000, 1),
(9, 9, 3100, 1),
(10, 10, 1200, 1),
(11, 11, 3600, 1),
(12, 12, 1200, 1);

--
-- Триггеры `venit`
--
DELIMITER $$
CREATE TRIGGER `trigger_venit` BEFORE UPDATE ON `venit` FOR EACH ROW IF NEW.suma_venit < 0
THEN SET NEW.suma_venit = 0; END IF
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cheltuieli`
--
ALTER TABLE `cheltuieli`
  ADD PRIMARY KEY (`id_cheltuieli`),
  ADD KEY `id_mat` (`id_mat`),
  ADD KEY `id_ang` (`id_ang`);

--
-- Индексы таблицы `dateang`
--
ALTER TABLE `dateang`
  ADD PRIMARY KEY (`id_ang`),
  ADD UNIQUE KEY `nameang` (`nameang`),
  ADD UNIQUE KEY `namepass` (`namepass`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id_profit`),
  ADD KEY `profit_ibfk_1` (`id_mat`),
  ADD KEY `profit_ibfk_2` (`id_ang`);

--
-- Индексы таблицы `resmateriale`
--
ALTER TABLE `resmateriale`
  ADD PRIMARY KEY (`id_mat`),
  ADD UNIQUE KEY `namemater` (`namemater`),
  ADD KEY `id_ang` (`id_ang`);

--
-- Индексы таблицы `venit`
--
ALTER TABLE `venit`
  ADD PRIMARY KEY (`id_venit`),
  ADD KEY `id_mat` (`id_mat`),
  ADD KEY `id_ang` (`id_ang`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cheltuieli`
--
ALTER TABLE `cheltuieli`
  MODIFY `id_cheltuieli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `dateang`
--
ALTER TABLE `dateang`
  MODIFY `id_ang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `profit`
--
ALTER TABLE `profit`
  MODIFY `id_profit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `resmateriale`
--
ALTER TABLE `resmateriale`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `venit`
--
ALTER TABLE `venit`
  MODIFY `id_venit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cheltuieli`
--
ALTER TABLE `cheltuieli`
  ADD CONSTRAINT `cheltuieli_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `resmateriale` (`id_mat`),
  ADD CONSTRAINT `cheltuieli_ibfk_2` FOREIGN KEY (`id_ang`) REFERENCES `dateang` (`id_ang`);

--
-- Ограничения внешнего ключа таблицы `profit`
--
ALTER TABLE `profit`
  ADD CONSTRAINT `profit_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `resmateriale` (`id_mat`) ON DELETE CASCADE,
  ADD CONSTRAINT `profit_ibfk_2` FOREIGN KEY (`id_ang`) REFERENCES `dateang` (`id_ang`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `resmateriale`
--
ALTER TABLE `resmateriale`
  ADD CONSTRAINT `resmateriale_ibfk_1` FOREIGN KEY (`id_ang`) REFERENCES `dateang` (`id_ang`);

--
-- Ограничения внешнего ключа таблицы `venit`
--
ALTER TABLE `venit`
  ADD CONSTRAINT `venit_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `resmateriale` (`id_mat`),
  ADD CONSTRAINT `venit_ibfk_2` FOREIGN KEY (`id_ang`) REFERENCES `dateang` (`id_ang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
