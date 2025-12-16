-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-12-12 07:38:52
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `company_system`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `quantity`, `created_at`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(15, 'キーボード', 4, '2025-09-17 11:27:14', '2025-09-18 11:13:07', 'testuser6', 1),
(20, 'PC', 6, '2025-09-18 10:35:08', '2025-09-19 11:29:31', 'testuser3', 1),
(21, 'キーボード', 4, '2025-09-18 10:35:13', '2025-11-11 10:42:40', 'admin11', 0),
(22, 'マウス', 8, '2025-09-18 10:35:20', '2025-11-11 10:42:47', 'admin11', 1),
(23, 'PC', 2, '2025-09-18 10:35:48', '2025-09-19 16:06:38', 'testuser3', 0),
(24, 'キーボード', 4, '2025-09-19 11:28:14', '2025-09-19 16:06:35', 'testuser3', 0),
(25, 'キーボード', 4, '2025-09-19 11:29:05', '2025-09-19 16:06:36', 'testuser3', 0),
(26, 'マウス', 3, '2025-09-19 11:29:19', '2025-09-19 15:58:57', 'testuser3', 0),
(27, 'ディスプレイ', 10, '2025-11-10 13:19:06', '2025-11-10 13:19:06', 'testuser13', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT '主キー',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `reset_token`, `reset_token_expire`) VALUES
(6, 'admin', '$2y$10$8yv3JUiNrgFgUnooV7Dqp.R6gjYQpiN30at/SpxFKiQEog0wEGIu.', '2025-09-05 13:49:41', NULL, NULL),
(7, 'admin', 'test12345', '2025-09-05 13:50:46', NULL, NULL),
(11, 'user1', '$2y$10$wOoqCD/XLvQdqd/jcE4ms.m6PpDbBArmMRehKtoXeUgLQNnm77KXC', '2025-09-11 09:10:48', NULL, NULL),
(12, 'admin11', '$2y$10$NzKxhLmDEmd8xHWTIRTzPeVsG/lhQW8SgIRswKAY0wqtIOUn0iJzC', '2025-09-11 10:43:39', NULL, NULL),
(13, 'admin22', '$2y$10$QnIqKy13Jhl0OBA5GKikwOfBbIvthccs425vEL2MW0uxT3TChiknC', '2025-09-11 13:40:15', NULL, NULL),
(14, 'testuser1', '$2y$10$zwCmXp1ujW0v8FdTigDeOueKm8Gn/rFimFRPB7Ga6/PS5a6tiiK4W', '2025-09-11 13:44:01', NULL, NULL),
(15, 'testuser2', '$2y$10$08lCB286/LagKAOSCHw12.JmKB/m3WIYFxRfjJOf.5t6l649Tj4eO', '2025-09-11 13:57:11', NULL, NULL),
(16, 'testuser3', '$2y$10$C2LMJ485aosM9frPO8yLZelIE.KX5kK1qpVCh88rZr83GQKNF1T/m', '2025-09-11 13:58:29', NULL, NULL),
(17, 'testuser4', '$2y$10$ID2Pzy/ht4g5EcVA9jG0YORsnu5nFWAj4L2uJ5hGZZvrHEhBBvnSK', '2025-09-11 14:09:34', NULL, NULL),
(18, 'testuser5', '$2y$10$S4SiazIKUTg53eeWd/6Cpef3x6Yxc4EwpgQhnne/P2m6TF12CVZYS', '2025-09-11 14:10:43', NULL, NULL),
(19, 'testuser6', '$2y$10$wAT5nO593hfH/CAQKTCvkekFt4uk3l4XNBuzOJaXcMuMP55qSVrGe', '2025-09-11 14:18:45', NULL, NULL),
(20, 'testuser7', '$2y$10$990PkY5I93XHjnN9B4AQl.3Lk/DpOT./bPSJxSn9t1.afII5jYbkW', '2025-09-11 14:23:22', NULL, NULL),
(21, 'testuser8', '$2y$10$mU6hrjDBjCEf318I4bn.OeOrc04XGUe528jnQT/cyy7CYRrWDWBKe', '2025-09-11 14:25:41', NULL, NULL),
(22, 'testuser9', '$2y$10$F2xc0j0eH/nuEGpN.oyrO.9PZ80Rs54VHGJ4OHdSQg0i.M0LKg3PS', '2025-09-11 15:27:17', NULL, NULL),
(23, 'testuser10', '$2y$10$c3ah9l2.VwAuzHGw/dV1lOcXujoi7Rvi/y4NhiWvTX.ON/Xs4NS6O', '2025-09-11 16:12:30', NULL, NULL),
(24, 'testuser11', '$2y$10$MBS3bjj1gANzDl2Q.YQuF.ukuuRzjQQ7naXJCi1JDT2fwTsQ4zwNm', '2025-09-19 10:48:30', NULL, NULL),
(25, 'testuser12', '$2y$10$A6.cw6X1kwNaEOl7UvHKUuHG81wzojoekJkfjN8onmeQOLJEaOMd.', '2025-09-19 15:30:19', NULL, NULL),
(26, 'testuser13', '$2y$10$hRGGMdhsup/AbWKEzX.yg.r4Jj7i0ayix2yxCrUO.V3ulLQl5/XXy', '2025-11-10 13:17:30', NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主キー', AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
