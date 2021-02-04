-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `user_accounts`;
CREATE TABLE `user_accounts` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `role` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `surname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `sip_id` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_accounts` (`id`, `role`, `name`, `surname`, `email`, `phone`, `sip_id`) VALUES
(1,	'user',	'Ivan',	'Ivanov',	'test@ivanov.ru',	'74996771864',	'496855'),
(2,	'user',	'Makar',	'Petrov',	'makar@petrov.com',	'78156067608',	'496855'),
(3,	'user',	'Akim',	'Melnik',	'akim@mel.com',	'111111111111',	'496855'),
(4,	'user',	'Zahar',	'Baden',	'baden@baden.ru',	'74996771864',	'496855'),
(5,	'mentor',	'Wanda',	'Maximoff',	'Maximoff@wanda.dc',	'1234567890',	'496855'),
(6,	'user',	'',	'',	'',	'78126037608',	'496855'),
(7,	'user',	'',	'',	'',	'380443318491',	'496855');

DROP TABLE IF EXISTS `user_calls`;
CREATE TABLE `user_calls` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `call_id` int(50) NOT NULL,
  `account_id` int(50) NOT NULL,
  `mentor_id` int(50) NOT NULL,
  `sip_id` int(50) NOT NULL,
  `from` bigint(20) NOT NULL,
  `to` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2021-02-04 10:55:26
