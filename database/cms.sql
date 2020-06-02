-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 29, 2020 at 07:53 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'avatar.png',
  `addedby` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `addedby`) VALUES
(1, 'May-18-2020 12:55:05', 'Josh', '1234', 'Josh Josh', 'Architect', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum sed vero mollitia', 'testimonial-img-1.jpg', 'Josh'),
(2, 'May-18-2020 13:11:36', 'Foreign', '1234', '', '', '', '', 'Josh'),
(3, 'May-18-2020 13:14:06', 'Peter', '1234', 'Petreli', '', '', '', 'Josh'),
(9, 'May-28-2020 19:40:10', 'admin', 'admin', 'trial Period', '', '', 'avatar.png', 'Josh'),
(7, 'May-27-2020 10:56:54', 'joshua', '1234', 'joshua Anthony', '', '', 'avatar.png', 'Josh'),
(8, 'May-28-2020 12:46:20', 'Erias', '08f90c1a417155361a5c4b8d297e0d78', 'New erias', '', '', 'avatar.png', 'Josh');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'Sports', 'Josh', 'May-14-2020 21:58:59'),
(2, 'Technology', 'Josh', 'May-14-2020 22:00:25'),
(4, 'Fitness', 'Josh', 'May-14-2020 22:07:40'),
(5, 'Programing', 'Josh', 'May-16-2020 09:38:55'),
(6, 'Science', 'Vitalis', 'May-20-2020 10:41:07'),
(7, 'Entertainment', 'Josh', 'May-28-2020 19:16:17'),
(8, 'Lifestyle', 'Josh', 'May-28-2020 19:41:41'),
(9, 'Health', 'Josh', 'May-28-2020 19:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(5, 'May-17-2020 14:27:20', 'Josh Erias', 'josherias10@gmail.com', 'Test comment one', 'Josh', 'ON', 3),
(6, 'May-17-2020 14:29:23', 'Foreign Josh', 'josherias10@gmail.com', 'Cars are the nicest things to grace the earth surface', 'Josh', 'ON', 10),
(7, 'May-18-2020 10:43:24', 'Top shutter', 'josherias10@gmail.com', 'This is nice', 'Josh', 'ON', 11),
(8, 'May-18-2020 10:44:03', 'Shutter the medea', 'Shutter@gmail.com', 'Shutter was here', 'Josh', 'ON', 9),
(9, 'May-18-2020 11:00:34', 'Josh Erias', 'Shutter@gmail.com', 'second comment', 'Pending', 'ON', 9),
(10, 'May-18-2020 11:40:10', 'Josh Erias', 'Topshutter@yahoo.com', 'New comment', 'Josh', 'ON', 9),
(11, 'May-21-2020 08:26:32', 'Foreign Josh', 'josherias10@gmail.com', 'This is a new test comment', 'Josh', 'ON', 14),
(12, 'May-21-2020 08:26:48', 'Mercy', 'Shutter@gmail.com', 'Comment by mercy', 'Pending', 'OFF', 14),
(13, 'May-21-2020 08:27:03', 'Notch', 'Topshutter@yahoo.com', 'Another comment', 'Josh', 'ON', 14),
(14, 'May-21-2020 08:31:11', 'Mercy', 'Topshutter@yahoo.com', 'To delete comment', 'Josh', 'ON', 14),
(16, 'May-21-2020 10:21:13', 'Shutter the medea', 'Topshutter@yahoo.com', 'This is to delete ', 'Pending', 'OFF', 14),
(17, 'May-22-2020 14:39:04', 'Notch', 'josherias10@gmail.com', 'New', 'Josh', 'ON', 3),
(18, 'May-22-2020 15:09:02', 'Josh Erias', 'Topshutter@yahoo.com', 'New Comment', 'Josh', 'ON', 6),
(19, 'May-28-2020 18:33:37', 'Tan', 'Topshutter@yahoo.com', 'Some cool cars ', 'Josh', 'ON', 9),
(20, 'May-28-2020 19:20:10', 'Foreign Josh', 'Shutter@gmail.com', 'I never saw this coming', 'Josh', 'ON', 15),
(21, 'May-28-2020 19:20:28', 'Notch', 'Shutter@gmail.com', 'This is gona be hella intresting', 'Josh', 'ON', 15),
(22, 'May-28-2020 19:37:50', 'Top shutter', 'josherias10@gmail.com', 'This is so not normal since he was the youngest MVP in history', 'Josh', 'ON', 19),
(23, 'May-28-2020 19:38:25', 'Foreign Josh', 'Shutter@gmail.com', 'This doesnt Matter. Al we know he is among the best to grace the court', 'Josh', 'ON', 19),
(24, 'May-28-2020 19:45:55', 'Kora', 'Kora@hotmail.com', 'How do i get this chance', 'Josh', 'ON', 20);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(10000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(3, 'May-15-2020 19:22:05', 'Testing', 'Sports', 'Josh', 'blog_img1.jpg', '                                                                                                                                                                                                                        Lorem ipsum dolor, sit amet consectetur adipisic\r\ning elit. Fuga excepturi nemo aspernatur magnam enim i\r\ntaque dolores praesentium! Tenetur ipsam fuga velit totam nulla v\r\noluptatibus quisquam voluptatem voluptas dolore consectetur, ab\r\n est eveniet placeat nostrum nesciunt nisi ipsum quo, consequatu\r\n r nam odio omnis magnam! Veritatis earum corporis magni sed recu\r\n sandae, repellat, delectus optio tenetur quae amet, at atque ha\r\n rum! Veritatis distinctio saepe iusto mollitia possimus quia voluptas sed quo laboriosam aspernatur quisqua\r\n m itaque porro amet veniam, autem cupiditate expedita reiciendis quasi.                                                                                                                                                                                                '),
(4, 'May-15-2020 19:22:39', 'Testing three times', 'Sports', 'Josh', 'banner-image.jpg', '                                                                                                            Testin my check                                                                                                                    '),
(6, 'May-15-2020 19:23:33', 'Fourth post  updated', 'Sports', 'Josh', 'banner-image-2.jpg', '   Testing again\r\n                                                      '),
(7, 'May-15-2020 19:23:52', 'Fifth Post', 'Sports', 'Josh', 'featured-img-3.jpg', '                                    Lorem ipsum dolor, sit amet consectetur adipisic\r\ning elit. Fuga excepturi nemo aspernatur magnam enim i\r\ntaque dolores praesentium! Tenetur ipsam fuga velit totam nulla v\r\noluptatibus quisquam voluptatem voluptas dolore consectetur, ab\r\n est eveniet placeat nostrum nesciunt nisi ipsum quo, consequatu\r\n r nam odio omnis magnam! Veritatis earum corporis magni sed recu\r\n sandae, repellat, delectus optio tenetur quae amet, at                                 '),
(9, 'May-15-2020 19:38:39', 'Top notch posts', 'Sports', 'Josh', 'facts_bg.jpg', '                                    this is the only post that wasworth waiting for in the year 2020 of the new tke business                                '),
(10, 'May-15-2020 19:45:22', 'Third Post here', 'Technology', 'Josh', 'listing_img2.jpg', 'this is to inform everyone'),
(11, 'May-15-2020 19:50:23', 'final trial post', 'Sports', 'Josh', 'banner-image.jpg', '                                    This is the next inline shutter                                '),
(12, 'May-16-2020 09:39:50', 'My final post', 'Sports', 'Josh', 'blog_img2.jpg', 'This is the only post that includes programming'),
(14, 'May-16-2020 09:56:22', 'Final posts of posts', 'Sports', 'Josh', 'testimonial-content-bg.jpg', '                                    This is another dummy post we trying our category field                                '),
(15, 'May-28-2020 19:18:12', 'Netflix to Sign Vagabond', 'Entertainment', 'Josh', 'thibault-penin-AWOl7qqsffM-unsplash.jpg', 'Netflix one of the biggest movie and entertainment companies is believed to sign Vagbond. Vagbond is a Korean Serie that premiered in 2018 and voted one of the best korean series of the year 2018'),
(16, 'May-28-2020 19:28:34', 'Odion Ighalo to sign New Contract Until January', 'Sports', 'Josh', 'people-watching-soccer-game-1884574.jpg', 'Manchester United and Shangai Shenua are expected to come to an agreement after Shangai provide a condition that Ighalo is to only remain at united till january for his long tern loan move of 6 months'),
(17, 'May-28-2020 19:29:51', 'Basket Ball to resume', 'Sports', 'Josh', 'four-people-playing-basketball-1080882.jpg', 'Basket Ball is set to resume in the NBA. Teams are set to return training by the end of this month'),
(18, 'May-28-2020 19:34:27', 'Night Clubs to open', 'Entertainment', 'Josh', 'audience-band-club-2747446.jpg', 'Night Clubs are set to open In China on a condition that masks are to be worn by each Individual'),
(19, 'May-28-2020 19:36:11', 'Why Derrick Rose May fail to make the NBA hall of fame', 'Sports', 'Josh', '5933937-nba-wallpapers-hd.jpg', 'Derrick Rose is said to be the only MVP in NBA history to not make the hall of fame '),
(20, 'May-28-2020 19:44:29', 'Get a free Vacation ', 'Lifestyle', 'Josh', 'img-34.jpg', 'Speke tours offers you  a chance to win a free tour and vacation in MIAMI FL'),
(21, 'May-28-2020 19:49:54', 'Tesla to Test their New ELectric Automobile', 'Technology', 'Josh', 'featured-img-3.jpg', 'Tesla is set to release its first electric vehicle by the end of this year. ');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
