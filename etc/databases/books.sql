CREATE SCHEMA IF NOT EXISTS `booksdb`;
USE `booksdb` ;

CREATE TABLE IF NOT EXISTS `booksdb`.`books` (
  `isbn` CHAR(10) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;