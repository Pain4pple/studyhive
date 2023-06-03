-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2023 at 05:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studyhive`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Body` text NOT NULL,
  `Date` datetime NOT NULL,
  `UpvoteCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `PostID`, `UserID`, `Body`, `Date`, `UpvoteCount`) VALUES
(1, 3, 8, 'OH NAURRRRRR', '2023-05-17 00:00:00', 487),
(2, 3, 9, 'Happy Birthday Cat Kang!!!', '2023-05-15 00:00:00', 105),
(10, 3, 5, '<h3>고마워 Thank you everyone!!!</h3>', '2023-05-20 00:00:00', 0),
(15, 3, 6, '<p><img src=\"https://media.tenor.com/WJ4G0IcF7pMAAAAC/newjeans-bunnies.gif\" alt=\"Newjeans Bunnies GIF - Newjeans Bunnies Tokki - Discover &amp; Share GIFs\"></p>', '2023-05-20 08:06:05', 0),
(16, 1, 6, '<p>let\'s gaurr</p>', '2023-05-20 08:23:20', 0),
(17, 1, 5, '<p>It was nice seeing you bunnies &lt;3</p>', '2023-05-20 08:24:20', 0),
(18, 1, 9, '<p>Best day of my life!!</p>', '2023-05-20 08:26:27', 0),
(21, 1, 7, '<p><img src=\"https://media.discordapp.net/attachments/1066306547644371048/1109449749922328607/2aec23ca013160eb.gif\"></p>', '2023-05-21 11:26:43', 0),
(22, 3, 9, '<p>test</p>', '2023-05-27 23:48:05', 0),
(23, 3, 6, '<p>I can comment because I am logged in!!</p>', '2023-06-01 10:58:01', 0),
(24, 9, 4, '<p>cute~</p>', '2023-06-01 21:41:35', 0),
(35, 15, 5, '<p>oks lang haha</p>', '2023-06-02 18:05:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `CommunityID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `ShortName` varchar(255) NOT NULL,
  `Logo` text NOT NULL,
  `Header` text NOT NULL,
  `Description` text NOT NULL,
  `Country` text NOT NULL,
  `Rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Rules`)),
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`CommunityID`, `Name`, `ShortName`, `Logo`, `Header`, `Description`, `Country`, `Rules`, `Date`) VALUES
(1, 'Bunnies Camp', 'Tokkis', '/resources/images/community image.jpg', '/resources/images/header.jpg', 'An unofficial place for tokkis to gather and socialize with fellow bunnies. Dedicated to NewJeans.', 'Korea', '{\r\n  \"1\": \"Always apply basic etiquette.\",\r\n  \"2\": \"Submissions must be about NewJeans.\",\r\n  \"3\": \"Respect your fellow Tokkis.\",\r\n  \"4\": \"Limit NSFW posts, please.\",\r\n  \"5\": \"Use downvotes wisely!\",\r\n  \"6\": \"Spread the word!\"\r\n}', '2023-04-12'),
(2, 'University of Santo Tomas', 'Thomasino', '/resources/images/schoolLogos/ust.png', '/resources/images/headerImages/ust-banner.jpg', 'A place for Tomasian cubs to gather and rawr 2gether', 'Philippines', '{\r\n  \"1\": \"Always apply basic etiquette.\",\r\n  \"2\": \"Submissions must be about UST.\",\r\n  \"3\": \"Respect your fellow Thomasians.\",\r\n  \"4\": \"Limit NSFW posts, please.\",\r\n  \"5\": \"Use downvotes wisely!\",\r\n  \"6\": \"No asking for School Recommendations\",\r\n  \"7\": \"Spread the word!\"\r\n}', '2023-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `nestedreplies`
--

CREATE TABLE `nestedreplies` (
  `NestedReplyID` int(11) NOT NULL,
  `ParentReplyID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Body` text NOT NULL,
  `Date` datetime NOT NULL,
  `UpvoteCount` int(11) NOT NULL,
  `replyingTo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nestedreplies`
--

INSERT INTO `nestedreplies` (`NestedReplyID`, `ParentReplyID`, `UserID`, `Body`, `Date`, `UpvoteCount`, `replyingTo`) VALUES
(1, 1, 7, 'ㅋㅋㅋㅋ', '2023-05-19 00:00:00', 231, 4),
(2, 1, 8, '<p>wazzaproblemm8?</p>', '2023-05-20 09:19:50', 0, 4),
(5, 1, 8, '<p>?????</p>', '2023-05-20 09:38:04', 0, 4),
(6, 1, 7, '<p>grrrrrrrr</p>', '2023-05-21 11:51:13', 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CommunityID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Body` text NOT NULL,
  `Media` text NOT NULL,
  `Date` datetime NOT NULL,
  `UpvoteCount` int(11) NOT NULL,
  `Comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `UserID`, `CommunityID`, `Title`, `Body`, `Media`, `Date`, `UpvoteCount`, `Comments`) VALUES
(1, 5, 1, '[안내📢]<br/>NewJeans 1st Fan Meeting \'Bunnies Camp\'', '<p>📅2023.5.15. MON. 2PM (KST) ~ 2023.5.17. WED. 2PM (KST)</p><p>🔗<a href=\"https://weverse.io/newjeansofficial/notice/13470\" target=\"_blank\">https://weverse.io/newjeansofficial/notice/13470</a></p><p>#NewJeans #뉴진스</p><p>#Bunnies_Camp #버니즈캠프</p>', '/resources/images/postMedias/postMedia_347256548_101422482963339_9191258991744063554_n.jpg', '2023-05-15 00:00:00', 684, 5),
(3, 6, 1, 'Happy Birthday, Haerin! 🐱🍰', '', '/resources/images/postMedias/postMedia_Fv-myDmWAAAuprR.jpg', '2023-05-15 14:37:16', 2399, 17),
(9, 6, 2, 'rawrrrr!!', '<p><img src=\"https://i.pinimg.com/564x/4b/3b/14/4b3b14ea19f48647bf3e0ef11de36ded.jpg\"></p>', '', '2023-06-01 21:09:06', 5, 2),
(15, 9, 2, 'Thoughts about IT Automation?', '<p>Hi! I am an incoming third year student in IT. I am still undecided on what track I should pursue. I feel pretty safe with web development but I really want to try and I am really curious about IT automation. Are there any automation students here who can share their experiences on the strand? How is it so far and is it worth it? Thank you!</p>', '', '2023-06-02 11:30:15', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `ReplyID` int(11) NOT NULL,
  `ParentCommentID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Body` text NOT NULL,
  `Date` datetime NOT NULL,
  `UpvoteCount` int(11) NOT NULL,
  `replyingTo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`ReplyID`, `ParentCommentID`, `UserID`, `Body`, `Date`, `UpvoteCount`, `replyingTo`) VALUES
(1, 1, 4, '?????', '2023-05-18 00:00:00', 536, ''),
(24, 2, 5, 'Thank you! 🐱', '2023-05-20 01:04:30', 0, 'testComment'),
(25, 1, 5, '😾', '2023-05-20 01:07:20', 0, 'testComment'),
(28, 1, 6, '<p>lololol</p>', '2023-05-20 08:07:25', 0, 'testComment'),
(29, 16, 5, '<p>let\'s gaurrrrr</p>', '2023-05-20 08:24:40', 0, 'testComment'),
(32, 10, 9, '<p>😻🤍</p>', '2023-05-20 08:32:51', 0, 'testComment'),
(33, 16, 7, '<p>let\'s gaur</p>', '2023-05-21 11:22:33', 0, ''),
(34, 15, 7, '<p><img src=\"https://media.discordapp.net/attachments/1066306547644371048/1109446698092216412/4a5c0836a4fe2b38.gif\"></p>', '2023-05-21 11:24:04', 0, ''),
(35, 24, 7, '<p>you never call me cute :((</p>', '2023-06-01 21:48:42', 0, ''),
(41, 35, 9, '<p>thanks...</p>', '2023-06-02 19:09:57', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `ThreadID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `ParentCommentID` int(11) NOT NULL,
  `ParentThreadID` int(11) NOT NULL,
  `hasChild` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ProfileImage` text NOT NULL,
  `DateJoined` date DEFAULT NULL,
  `Bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Email`, `Username`, `Password`, `ProfileImage`, `DateJoined`, `Bio`) VALUES
(4, 'hanni.pham@adorlabels.kr', 'hanni_bunch', '5af83e3196bf99f440f31f2e1a6c9afe', '/resources/images/userImages/UserImage_6461a01d7c7ee6.21941254.jpg', '2023-05-03', ''),
(5, 'kang_hwaewin@adorlabels.kr', 'haerin~', '1955598fff3c9d982b8fe344d59fe955', '/resources/images/userImages/UserImage_6461c9ac651d75.39312207.jpg', '2023-04-28', ''),
(6, 'lee.hyein@adorlabels.kr', 'hyeinnn', '4c4a9fd7f4a4a416922b64bb3060bcd3', '/resources/images/userImages/UserImage_6461cb26174329.13978396.jpg', '2023-05-01', '<p><img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/NewJeans_Logo_1.svg/2560px-NewJeans_Logo_1.svg.png\" alt=\"File:NewJeans Logo 1.svg - Wikimedia Commons\"></p>'),
(7, 'kim.min-ji@adorlabels.kr', 'minji.tokki', '1ff61e91349d3f6623a81ccd3d881fa1', '/resources/images/userImages/UserImage_6462c6c1ab4b78.35138837.png', '2023-04-25', ''),
(8, 'daniellejune.marsh@adorlabels.kr', 'sunflower-dani', '41fca3a29aaddd9a004fd0156a45426b', '/resources/images/userImages/UserImage_64669f59eac3c8.57397346.jpg', '2023-05-03', ''),
(9, 'kittenstuart@gmail.com', 'stuart', '407cb3436f86acc235172e57027af714', '/resources/images/userImages/UserImage_6466a09c92c8b5.46430806.jpg', '2023-05-12', '<p>I am stuart</p><p><br></p>'),
(10, 'programmurLara@gmail.com', 'programmur', '202cb962ac59075b964b07152d234b70', '/resources/images/userImages/UserImage_6479f3e3396dd5.14397351.png', NULL, ''),
(11, 'acert123@gmail.com', 'ace', 'aa5be6789de6fd2c9d7f53f79415e693', '/resources/images/userImages/UserImage_647aa96b475555.60583308.jpg', NULL, '<p>is my hair too short?</p>');

-- --------------------------------------------------------

--
-- Table structure for table `uservotes`
--

CREATE TABLE `uservotes` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uservotes`
--

INSERT INTO `uservotes` (`PostID`, `UserID`, `Vote`) VALUES
(1, 5, 1),
(3, 5, 1),
(1, 6, 1),
(3, 6, 1),
(9, 6, 0),
(9, 4, 1),
(1, 4, 1),
(3, 4, 1),
(9, 7, 1),
(9, 8, 1),
(3, 8, 1),
(1, 8, 1),
(3, 9, 1),
(9, 9, 1),
(1, 9, 1),
(15, 6, 1),
(15, 5, 1),
(9, 5, 1),
(15, 9, 0),
(1, 11, 1),
(15, 11, 0),
(9, 11, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `PostID` (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`CommunityID`);

--
-- Indexes for table `nestedreplies`
--
ALTER TABLE `nestedreplies`
  ADD PRIMARY KEY (`NestedReplyID`),
  ADD KEY `ParentReplyID` (`ParentReplyID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `replyingTo` (`replyingTo`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CommunityID` (`CommunityID`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`ReplyID`),
  ADD KEY `ThreadID` (`ParentCommentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ParentCommentID` (`ParentCommentID`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`ThreadID`),
  ADD KEY `PostID` (`PostID`),
  ADD KEY `ParentID` (`ParentCommentID`),
  ADD KEY `ParentThreadID` (`ParentThreadID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `uservotes`
--
ALTER TABLE `uservotes`
  ADD KEY `PostID` (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `CommunityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nestedreplies`
--
ALTER TABLE `nestedreplies`
  MODIFY `NestedReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `ReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `ThreadID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE;

--
-- Constraints for table `nestedreplies`
--
ALTER TABLE `nestedreplies`
  ADD CONSTRAINT `nestedreplies_ibfk_1` FOREIGN KEY (`ParentReplyID`) REFERENCES `replies` (`ReplyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `nestedreplies_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `nestedreplies_ibfk_3` FOREIGN KEY (`replyingTo`) REFERENCES `replies` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`CommunityID`) REFERENCES `community` (`CommunityID`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`ParentCommentID`) REFERENCES `comments` (`CommentID`) ON DELETE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`),
  ADD CONSTRAINT `threads_ibfk_2` FOREIGN KEY (`ParentCommentID`) REFERENCES `comments` (`CommentID`),
  ADD CONSTRAINT `threads_ibfk_3` FOREIGN KEY (`ParentThreadID`) REFERENCES `threads` (`ThreadID`);

--
-- Constraints for table `uservotes`
--
ALTER TABLE `uservotes`
  ADD CONSTRAINT `uservotes_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `uservotes_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
