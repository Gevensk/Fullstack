-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 06:33 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fullstack`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE `achievement` (
  `idachievement` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `achievement`
--

INSERT INTO `achievement` (`idachievement`, `idteam`, `name`, `date`, `description`) VALUES
(1, 1, 'Runner Up 2024', '2024-10-25', 'qwertu'),
(2, 2, 'Juara Dunia Mobile Legends M1 World Champions', '2023-05-16', 'mantap'),
(3, 2, 'The Winner MPL ID Season 4', '2023-07-12', 'jiwa'),
(4, 3, 'Juara 1 Mobile Legends: Bang Bang Southeast A', '2024-01-23', 'dbjbovsbviosdnvis'),
(5, 3, 'Juara Mobile Legends Mytel Internasional Cham', '2022-09-08', 'facioaag'),
(6, 4, 'PUBG Mobile World League 2020', '2020-10-25', 'akfnakfaf'),
(7, 4, 'Juara 3 MPL Season 6', '2023-09-01', 'akffbaf'),
(8, 2, 'tes', '2024-10-16', 'lorem loremann'),
(9, 1, 'tes rrq', '2024-10-07', 'lorem'),
(10, 2, 'tes3', '2024-10-24', 'testing'),
(11, 2, '2nd Runner Up MLBB Regional Showdown', '2024-09-10', 'slebeww'),
(19, 27, 'Champion of Valorant Championship', '2024-11-20', 'Lorem ipman');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `idevent` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`idevent`, `name`, `date`, `description`) VALUES
(1, 'Valorant Championship', '2024-09-12', 'Valorant Event'),
(2, 'PUBG Mobile Super League – SEA Spring 2024', '2024-10-10', 'PUBG event'),
(3, 'MPL Indonesia Season 13', '2024-10-24', 'Mobile Legend Event'),
(4, 'VCT 2024: Game Changers EMEA Stage 1', '2024-11-16', 'Valorant Event'),
(5, 'DreamLeague Season 22', '2024-11-13', 'Dota 2 Event'),
(6, 'Free Fire World Series – Southeast Asia Sprin', '2024-12-10', 'Free Fire Event'),
(7, 'Free Fire Regional Qualifiers', '2024-10-06', 'Free Fire Events'),
(8, 'PMPL Season 7', '2024-10-01', 'PUBG Event'),
(9, 'Valorant Funmatch 2024', '2024-10-19', 'Valorant Funmatch'),
(10, 'League of Legends Global Tournament', '2024-10-25', 'League of Legends event'),
(13, 'MPL Indonesia Season 14', '2024-11-01', 'Mobile Legends Professional League');

-- --------------------------------------------------------

--
-- Table structure for table `event_teams`
--

CREATE TABLE `event_teams` (
  `idevent` int(11) NOT NULL,
  `idteam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_teams`
--

INSERT INTO `event_teams` (`idevent`, `idteam`) VALUES
(1, 1),
(1, 17),
(2, 32),
(3, 4),
(4, 17),
(8, 32),
(9, 1),
(9, 17);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `idgame` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`idgame`, `name`, `description`) VALUES
(1, 'Valorant', 'Valorant adalah permainan video POP taktis multipemain gratis yang dikembangkan dan diterbitkan oleh Riot Games, untuk Microsoft Windows.'),
(2, 'Dota 2', 'Dota 2 adalah sebuah permainan arena pertarungan daring multipemain, dan merupakan sekuel dari Defense of the Ancients mod pada Warcraft 3: Reign of Chaos dan Warcraft 3: The Frozen Throne.'),
(3, 'Mobile Legends', 'A mobile multiplayer online battle arena (MOBA) game developed and published by Chinese developer Moonton'),
(4, 'Free Fire', 'Free-to-play battle royale game developed and published by Garena for Android and iOS'),
(5, 'PUBG', 'Battle royale game developed by PUBG Studios and published by Krafton'),
(6, 'League of Legends', 'A team-based game with over 140 champions to make epic plays with'),
(9, 'Honor of Kings', 'Honor of Kings, secara tidak resmi diterjemahkan sebagai \"King of Glory,\" atau ditransliterasikan sebagai Wangzhe Rongyao) adalah sebuah permainan arena pertarungan daring multipemain yang dikembangka');

-- --------------------------------------------------------

--
-- Table structure for table `join_proposal`
--

CREATE TABLE `join_proposal` (
  `idjoin_proposal` int(11) NOT NULL,
  `idmember` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` enum('waiting','setuju','tolak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `join_proposal`
--

INSERT INTO `join_proposal` (`idjoin_proposal`, `idmember`, `idteam`, `description`, `status`) VALUES
(6, 5, 4, 'I will do my best for this team', 'setuju'),
(15, 3, 3, 'I Want to Join this team', 'setuju'),
(17, 5, 1, 'I want to join this team', 'setuju'),
(22, 6, 1, 'Sentinels right here!!', 'setuju'),
(23, 7, 1, 'Good at Snipers', 'setuju'),
(24, 3, 2, 'testing', 'setuju'),
(25, 5, 17, 'Hehe', 'setuju'),
(26, 3, 17, 'Over-Powered Duelist', 'setuju'),
(27, 5, 2, 'testingg', 'waiting'),
(29, 5, 27, 'lets go', 'waiting'),
(30, 3, 27, 'Together we can be a best team ever', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `idmember` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `profile` enum('user','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`idmember`, `fname`, `lname`, `username`, `password`, `profile`) VALUES
(3, 'Jin', 'Kazama', 'jin', '$2y$10$p3D0O/ugb/ZOsL12VGxQ7u8JB.70GmsoZKbkhNFt.FHs3I531DPtm', 'user'),
(4, 'Vilen', 'Alycia', 'len', '$2y$10$qIovUywndvU5I/A6JCVQCOIKx1Bl1uOrL/n.tYr2QwoGWJ3WhDAGG', 'admin'),
(5, 'Kazuya', 'Mishima', 'kaz', '$2y$10$Qiy7zQnb160FYfIQQ.eH9O5MFLeDdAsMU0RfmYVuzyDq9yPVZ6/KO', 'user'),
(6, 'Grace', 'V', 'grace', '$2y$10$i19tWq2qPxWuu.fBwN490OtbHTgGcmlG8zFrCMFurgP1qhqqqiDvW', 'user'),
(7, 'Marshanda', 'P', 'mar', '$2y$10$.26Yo.fd6bv.Eg6eTu4nMOI63yw/59.BT2jhnwSj4z6eC2gMQaVJS', 'user'),
(8, 'Marshall', 'Law', 'law', '$2y$10$Q3B/ztBR0FWii9g80Fm8y.VuZBy3BDs1CJu7.w5QSukhskSqmoumi', 'user'),
(9, 'Billy', 'Joel', 'bill', '$2y$10$pFsUZf4p6pCzo4rXu.onQe.mo.Stk0NUprp1WI06fj/kgFMHpeq.u', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `idteam` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`idteam`, `idgame`, `name`) VALUES
(1, 1, 'RRQ'),
(2, 6, 'EVOS'),
(3, 3, 'ONIC'),
(4, 3, 'Bigetron'),
(8, 5, 'Fnatic'),
(17, 1, 'PRX'),
(27, 1, 'Sentinels'),
(30, 3, 'Alter Ego'),
(31, 3, 'Geek Fam'),
(32, 5, 'Aura Esports');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `idteam` int(11) NOT NULL,
  `idmember` int(11) NOT NULL,
  `description` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`idteam`, `idmember`, `description`) VALUES
(1, 5, 'Bergabung pada 2024-October-17'),
(1, 6, 'Bergabung pada 2024-October-17'),
(1, 7, 'Bergabung pada 2024-October-17'),
(2, 3, 'Bergabung pada 2024-October-17'),
(3, 3, 'Bergabung pada 2024-October-13'),
(4, 5, 'Bergabung pada 2024-October-13'),
(17, 3, 'Bergabung pada 2024-November-13'),
(17, 5, 'Bergabung pada 2024-November-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`idachievement`),
  ADD KEY `fk_achievement_team1_idx` (`idteam`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`idevent`);

--
-- Indexes for table `event_teams`
--
ALTER TABLE `event_teams`
  ADD PRIMARY KEY (`idevent`,`idteam`),
  ADD KEY `fk_event_has_team_team1_idx` (`idteam`),
  ADD KEY `fk_event_has_team_event1_idx` (`idevent`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`idgame`);

--
-- Indexes for table `join_proposal`
--
ALTER TABLE `join_proposal`
  ADD PRIMARY KEY (`idjoin_proposal`),
  ADD KEY `fk_join_proposal_member1_idx` (`idmember`),
  ADD KEY `fk_join_proposal_team1_idx` (`idteam`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idmember`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`idteam`),
  ADD KEY `fk_team_game_idx` (`idgame`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`idteam`,`idmember`),
  ADD KEY `fk_team_has_member_member1_idx` (`idmember`),
  ADD KEY `fk_team_has_member_team1_idx` (`idteam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement`
--
ALTER TABLE `achievement`
  MODIFY `idachievement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `idevent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `idgame` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `join_proposal`
--
ALTER TABLE `join_proposal`
  MODIFY `idjoin_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `idmember` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `idteam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement`
--
ALTER TABLE `achievement`
  ADD CONSTRAINT `fk_achievement_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_teams`
--
ALTER TABLE `event_teams`
  ADD CONSTRAINT `fk_event_has_team_event1` FOREIGN KEY (`idevent`) REFERENCES `event` (`idevent`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_has_team_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `join_proposal`
--
ALTER TABLE `join_proposal`
  ADD CONSTRAINT `fk_join_proposal_member1` FOREIGN KEY (`idmember`) REFERENCES `member` (`idmember`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_join_proposal_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_game` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `fk_team_has_member_member1` FOREIGN KEY (`idmember`) REFERENCES `member` (`idmember`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_team_has_member_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
