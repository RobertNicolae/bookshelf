-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bookshelf
CREATE DATABASE IF NOT EXISTS `bookshelf` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bookshelf`;

-- Dumping structure for table bookshelf.author
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.author: ~1 rows (approximately)
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` (`id`, `name`) VALUES
	(1, 'Tot');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;

-- Dumping structure for table bookshelf.author_book
CREATE TABLE IF NOT EXISTS `author_book` (
  `author_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  KEY `FK_authorID` (`author_id`),
  KEY `FK_bookID` (`book_id`),
  CONSTRAINT `FK_authorID` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_bookID` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.author_book: ~0 rows (approximately)
/*!40000 ALTER TABLE `author_book` DISABLE KEYS */;
/*!40000 ALTER TABLE `author_book` ENABLE KEYS */;

-- Dumping structure for table bookshelf.book
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `description` text,
  `total_pages` int(11) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_publisherID` (`publisher_id`),
  KEY `FK_userID` (`user_id`),
  CONSTRAINT `FK_publisherID` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_userID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.book: ~1 rows (approximately)
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`id`, `name`, `publisher_id`, `user_id`, `isbn`, `description`, `total_pages`, `cover_image`) VALUES
	(1, 'SQL', 1, 1, '321e231321', NULL, 232, 'test.jpg');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Dumping structure for table bookshelf.publisher
CREATE TABLE IF NOT EXISTS `publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.publisher: ~1 rows (approximately)
/*!40000 ALTER TABLE `publisher` DISABLE KEYS */;
INSERT INTO `publisher` (`id`, `name`) VALUES
	(1, 'Cristi');
/*!40000 ALTER TABLE `publisher` ENABLE KEYS */;

-- Dumping structure for table bookshelf.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `password`, `created`, `role`) VALUES
	(1, 'email@test.ro', 'bla', '2021-01-16 14:22:09', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table bookshelf.user_book
CREATE TABLE IF NOT EXISTS `user_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `pages` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_book_user` (`user_id`),
  KEY `FK_user_book_book` (`book_id`),
  CONSTRAINT `FK_user_book_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_book_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bookshelf.user_book: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_book` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_book` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
