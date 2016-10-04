-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventId` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8_czech_ci NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eventId` (`eventId`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `categories` (`id`, `eventId`, `name`, `description`) VALUES
(1,	1,	'Úroveň lekcí',	'Zvolte prosím, jaký level Lindy Hop Vám odpovídá'),
(2,	1,	'Sobotní oběd',	'Vyberte si, na jaký oběd máte v sobotu chuť'),
(3,	1,	'Tričko',	'Chcete tričko? Tady máte možnost ho objednat!');

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8_czech_ci NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `events` (`id`, `name`, `description`) VALUES
(1,	'Dummy PSX',	'Velmi volný a placený event, který je založený pouze pro účely testingu');

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8_czech_ci NOT NULL,
  `info` text COLLATE utf8_czech_ci,
  `priceCZK` int(11) NOT NULL,
  `priceEUR` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `options` (`id`, `categoryId`, `name`, `info`, `priceCZK`, `priceEUR`) VALUES
(1,	1,	'Začátečník',	'Nikdy jsem netančil',	300,	19),
(2,	1,	'Mírně pokročilý',	'Umím počítat do šesti, do osmi a nepadám co pět minut',	300,	19),
(3,	1,	'Pokročilý',	'Aereals a jazz steps jsou moje druhé já',	300,	19),
(4,	2,	'Bramboráky',	'Jsou chutné, ale pozor na lepek!',	300,	19),
(5,	2,	'Guláš',	'Český s pěti (občas i čtyřmi)',	300,	19),
(6,	2,	'Salát',	'Vlastně moc nedpopručujeme - je v něm spousta zeleniny a ovoce (například oliv či rajčat) a tedy není výživově příliš vhodný pro náročné vypětí sil, jaké na lekcích budou',	300,	19),
(7,	3,	'Nechci tričko',	'',	300,	19),
(8,	3,	'pánské XL',	NULL,	300,	19),
(9,	3,	'dámské XL',	NULL,	300,	19),
(10,	3,	'dámské L',	NULL,	300,	19),
(11,	3,	'pánské L',	NULL,	300,	19),
(12,	3,	'dámské M',	NULL,	300,	19),
(13,	3,	'pánské M',	'menší než malé',	300,	19);

-- 2016-10-04 19:54:40
