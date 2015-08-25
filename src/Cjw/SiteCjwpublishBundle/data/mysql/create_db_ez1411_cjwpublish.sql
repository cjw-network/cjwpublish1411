
--- create db
-- CREATE SCHEMA `ez1411_cjwpublish` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
--

-- create mysql user  'cjwpublish'
-- create db  ez1411_cjwpublish and give all right to user cjwpublish

-- DROP USER  'cjwpublish'@'localhost';

CREATE USER 'cjwpublish'@'localhost' IDENTIFIED BY 'cjwpublish';

-- GRANT USAGE ON *.* TO 'cjwpublish'@'localhost' IDENTIFIED BY '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE DATABASE IF NOT EXISTS `ez1411_cjwpublish` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT ALL PRIVILEGES ON `ez1411_cjwpublish`.* TO 'cjwpublish'@'localhost';

-- USE `ez1411_cjwpublish`;