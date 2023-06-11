-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2023 at 10:56 PM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_sell`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nome`, `password`) VALUES
(2, 'luiz', '51eac6b471a284d3341d8c0c63d0f1a286262a18'),
(3, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` int(10) NOT NULL,
  `quantidade` int(10) NOT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carrinho`
--

INSERT INTO `carrinho` (`id`, `user_id`, `pid`, `nome`, `preco`, `quantidade`, `imagem`) VALUES
(27, 10, 11, 'Geladeira Gela tudo', 3699, 1, 'fridge-1.webp'),
(28, 10, 14, 'mouse', 50, 1, 'mouse-1.webp'),
(53, 15, 9, 'smartphone realme c21Y', 2500, 1, 'smartphone-1.webp');

-- --------------------------------------------------------

--
-- Table structure for table `contador_pedidos`
--

CREATE TABLE `contador_pedidos` (
  `id` int(10) NOT NULL,
  `completados` int(10) NOT NULL DEFAULT 0,
  `ultimo_pedido_nome` varchar(20) NOT NULL,
  `ultimo_pedido_data` datetime DEFAULT NULL,
  `ultimo_pedido_valor` int(10) NOT NULL,
  `ultimo_pedido_admin` varchar(20) NOT NULL,
  `pagamento_status` varchar(50) DEFAULT 'completado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contador_pedidos`
--

INSERT INTO `contador_pedidos` (`id`, `completados`, `ultimo_pedido_nome`, `ultimo_pedido_data`, `ultimo_pedido_valor`, `ultimo_pedido_admin`, `pagamento_status`) VALUES
(3, 1, 'Jordson kleiton', NULL, 3699, '2', 'completado'),
(4, 1, 'Ana Cristina', NULL, 480, '3', 'completado'),
(5, 1, 'jordson', NULL, 480, '3', 'completado');

-- --------------------------------------------------------

--
-- Table structure for table `mensagem`
--

CREATE TABLE `mensagem` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numero` varchar(12) NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mensagem`
--

INSERT INTO `mensagem` (`id`, `user_id`, `nome`, `email`, `numero`, `mensagem`) VALUES
(4, 12, 'mariazinha', 'mariazinha@gmail.com', '', 'Muito bom! chegou no prazo e sem avarias no produtos.');

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `endereco` varchar(500) NOT NULL,
  `total_prod` varchar(100) NOT NULL,
  `total_preco` int(10) NOT NULL,
  `pagamento_status` varchar(20) NOT NULL DEFAULT 'pendente',
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `user_id`, `nome`, `numero`, `email`, `metodo`, `endereco`, `total_prod`, `total_preco`, `pagamento_status`, `data`) VALUES
(9, 8, 'Jordson kleiton', '(35)99882-0044', 'admin@gmail.com', 'paypal', 'dsd, , CambuÃ­, ca, cvv - 123456', 'smartphone China Wall (1500 x 1)  ', 1500, 'pendente', NULL),
(11, 10, 'Jose Augusto', '(35)96963-7895', 'joseaugusto@gmail.com', 'pagamento na entrega', 'rua JoÃ£o versolato, , Extrema, MG, Brasil - 37700000', 'smartphone China Wall (1500 x 1)  ', 1500, 'pendente', NULL),
(12, 12, 'mariazinha', '(35)96963-7895', 'mariazinha@gmail.com', 'pagamento na entrega', 'rua prefeito joÃ£o, , Itapeva, MG, Brasil - 37800000', 'tv (6000 x 1)  ', 6000, 'pendente', NULL),
(14, 14, 'Marcos', '(11)96578-8289', 'marcos.vinicius.94@hotmail.com.br', 'cartÃ£o de crÃ©dito', 'Ãlvaro Lins, , Santo AndrÃ©, SÃ£o Paulo, Brasil - 09130160', 'laptop  (6000 x 1)  ', 6000, 'pendente', NULL),
(15, 14, 'Raphael', '(11)97878-9898', 'Raphael.Adriano@outlook.com', 'pix', 'Rua itaiba, 42044, SÃ£o Bernardo, SÃ£o Paulo, Brasil - 09761070', 'tv (6000 x 1)  mouse (50 x 1)  Geladeira Gela tudo (3699 x 1)  ', 9749, 'pendente', NULL),
(16, 15, 'JOSE HENRIQUE BARBOZ', '(11)97653-0125', 'henriqueebarbozaa@gmail.com', 'pagamento na entrega', 'Eca De Queiroz, 126, Diadema, SP, Brasil - 09931040', 'laptop  (6000 x 1)  Geladeira Gela tudo (3699 x 1)  tv (6000 x 1)  ', 15699, 'pendente', NULL),
(17, 12, 'Mariazinha', '(35)12345-6524', 'mariazinha@gmail.com', 'pix', 'Rua itaiba , , SÃ£o Bernardo , SP, Brasil - 3760000', 'tv (6000 x 1)  ', 6000, 'pendente', NULL),
(18, 18, 'Rayane', '(35)98765-1234', 'rayane.sousas@icloud.com', 'pagamento na entrega', '77, Passagem Bela Flor do Campo , SÃ£o Paulo , SP, Brasil  - 09930438', 'smartphone realme c21Y (2500 x 1)  laptop  (6000 x 1)  ', 8500, 'pendente', NULL),
(19, 16, 'Maykon da Matta ', '(35)98765-1234', 'maykonmatta@icloud.com', 'pix', 'Viela Flor-do-Campo, 77, , Diadema, SP, Brasil - 09930438', 'laptop  (6000 x 1)  mouse (50 x 1)  ', 6050, 'pendente', NULL),
(20, 18, 'Rayane', '(35)98765-1234', 'rayane.sousas@icloud.com', 'pagamento na entrega', '77, Passagem Bela Flor do Campo , SÃ£o Paulo , SP, Brasil  - 09930438', 'laptop  (6000 x 1)  ', 6000, 'pendente', NULL),
(21, 16, 'Maykon', '(35)98765-1234', 'maykonmatta@icloud.com', 'paypal', 'Rua Tiradentes, 2356, , SÃ£o Bernardo do Campo, SP, Brasil - 09930300', 'smartphone realme c21Y (2500 x 1)  ', 2500, 'pendente', NULL),
(22, 18, 'Rayane', '(35)98765-1234', 'rayane.sousa@icloud.com', 'cartÃ£o de crÃ©dito', '77, Passagem Bela Flor do Campo , SÃ£o Paulo , Sp, Brasil  - 09930438', 'smartphone realme c21Y (2500 x 1)  ', 2500, 'pendente', NULL),
(23, 17, 'Thaina Barros', '(35)98765-1234', 'thainabarrosouza@hotmail.com', 'cartÃ£o de crÃ©dito', 'Passagem Bela Flor, 777, SÃ£o Paulo , SP, Brasil - 09930438', 'laptop  (6000 x 1)  mouse (50 x 1)  ', 6050, 'pendente', NULL),
(24, 17, 'THAINA BARROS DE SOU', '(35)98765-1234', 'thainabarrosouza@hotmail.com', 'cartÃ£o de crÃ©dito', 'Passagem Bela Flor , 77, Diadema, SP, Brasil - 09930438', 'laptop  (6000 x 1)  mouse (50 x 1)  ', 6050, 'pendente', NULL),
(25, 16, 'Maykon', '(35)98765-1234', 'maykonmatta@icloud.com', 'paypal', 'Rua Tiradentes, 2356, , SÃ£o Bernardo do Campo, SP, Brasil - 09930430', 'tv (6000 x 1)  ', 6000, 'pendente', NULL),
(26, 15, 'JOSE HENRIQUE BARBOZ', '(11)97653-0125', 'henriqueebarbozaa@gmail.com', 'pix', 'Eca De Queiroz, 126, Diadema, SP, Brasil - 09931040', 'tv (6000 x 1)  ', 6000, 'pendente', NULL),
(27, 19, 'Ana Cristina ', '(35)98765-1234', 'ana.csbarros@gmail.com', 'pagamento na entrega', 'Rua , AntÃ´nio de Moraes , , CambuÃ­ , MG, Brasil  - 37600000', 'tv (6000 x 1)  smartphone realme c21Y (2500 x 1)  Mixer (150 x 1)  ', 8650, 'pendente', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `detalhes` varchar(500) NOT NULL,
  `preco` float NOT NULL DEFAULT 0,
  `imagem_01` varchar(100) NOT NULL,
  `imagem_02` varchar(100) NOT NULL,
  `imagem_03` varchar(100) NOT NULL,
  `old_imagem_01` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `detalhes`, `preco`, `imagem_01`, `imagem_02`, `imagem_03`, `old_imagem_01`) VALUES
(9, 'smartphone realme c21Y', 'Ã© do bom', 2500, 'smartphone-1.webp', 'smartphone-2.webp', 'smartphone-3.webp', NULL),
(11, 'Geladeira Gela tudo', 'Geladeira de alta classe', 3699, 'fridge-1.webp', 'fridge-2.webp', 'fridge-3.webp', NULL),
(12, 'laptop ', 'da marca boa', 6000, 'laptop-1.webp', 'laptop-2.webp', 'laptop-3.webp', NULL),
(13, 'Mixer', 'Fotos', 150, 'mixer-1.webp', 'mixer-2.webp', 'mixer-3.webp', NULL),
(14, 'mouse', 'mouse para pc', 50, 'mouse-1.webp', 'mouse-2.webp', 'mouse-3.webp', NULL),
(15, 'tv', '4k', 6000, 'tv-01.webp', 'tv-02.webp', 'tv-03.webp', NULL);

--
-- Triggers `produtos`
--
DELIMITER $$
CREATE TRIGGER `produtos_after_delete` AFTER DELETE ON `produtos` FOR EACH ROW BEGIN
INSERT INTO `produtos_log` (`action`, `id`, `nome`, `detalhes`, `preco`, `imagem_01`, `imagem_02`, `imagem_03`, `old_imagem_01`) 
  VALUES ('DELETE', OLD.id, OLD.nome, OLD.detalhes, OLD.preco, OLD.imagem_01, OLD.imagem_02, OLD.imagem_03, OLD.old_imagem_01);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `produtos_after_update` AFTER UPDATE ON `produtos` FOR EACH ROW BEGIN
 INSERT INTO `produtos_log` (`action`, `id`, `nome`, `detalhes`, `preco`, `imagem_01`, `imagem_02`, `imagem_03`, `old_imagem_01`) 
  VALUES ('UPDATE', NEW.id, NEW.nome, NEW.detalhes, NEW.preco, NEW.imagem_01, NEW.imagem_02, NEW.imagem_03, NEW.old_imagem_01);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `produtos_before_insert` BEFORE INSERT ON `produtos` FOR EACH ROW BEGIN
  INSERT INTO `produtos_log` (`action`, `id`, `nome`, `detalhes`, `preco`, `imagem_01`, `imagem_02`, `imagem_03`, `old_imagem_01`) 
  VALUES ('INSERT', NEW.id, NEW.nome, NEW.detalhes, NEW.preco, NEW.imagem_01, NEW.imagem_02, NEW.imagem_03, NEW.old_imagem_01);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produtos_log`
--

CREATE TABLE `produtos_log` (
  `log_id` int(10) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` varchar(50) NOT NULL,
  `id` int(10) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `detalhes` varchar(500) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `imagem_01` varchar(100) DEFAULT NULL,
  `imagem_02` varchar(100) DEFAULT NULL,
  `imagem_03` varchar(100) DEFAULT NULL,
  `old_imagem_01` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produtos_log`
--

INSERT INTO `produtos_log` (`log_id`, `log_time`, `action`, `id`, `nome`, `detalhes`, `preco`, `imagem_01`, `imagem_02`, `imagem_03`, `old_imagem_01`) VALUES
(7, '2023-05-29 03:33:39', 'INSERT', 0, 'relÃ³gio', 'relÃ³gio  do braz', 500, 'watch-1.webp', 'watch-2.webp', 'watch-3.webp', NULL),
(8, '2023-05-29 22:36:47', 'UPDATE', 7, 'notebook', 'coisa boa', 500, 'laptop-1.webp', 'laptop-2.webp', 'laptop-3.webp', NULL),
(9, '2023-06-05 04:27:21', 'DELETE', 7, 'notebook', 'coisa boa', 500, 'laptop-1.webp', 'laptop-2.webp', 'laptop-3.webp', NULL),
(10, '2023-06-05 04:27:23', 'DELETE', 8, 'relÃ³gio', 'relÃ³gio  do braz', 500, 'watch-1.webp', 'watch-2.webp', 'watch-3.webp', NULL),
(11, '2023-06-06 19:33:03', 'INSERT', 0, 'smartphone China Wall', 'Ã© do bom', 1500, 'smartphone-1.webp', 'smartphone-2.webp', 'smartphone-3.webp', NULL),
(12, '2023-06-06 19:34:31', 'INSERT', 0, 'CÃ¢mera Super pix', 'Qualidade da boa ', 480, 'camera-1.webp', 'camera-2.webp', 'camera-3.webp', NULL),
(13, '2023-06-06 19:36:29', 'INSERT', 0, 'Geladeira Gela tudo', 'Geladeira de alta classe', 3699, 'fridge-1.webp', 'fridge-2.webp', 'fridge-3.webp', NULL),
(14, '2023-06-06 19:37:23', 'INSERT', 0, 'laptop ', 'da marca boa', 6000, 'laptop-1.webp', 'laptop-2.webp', 'laptop-3.webp', NULL),
(15, '2023-06-06 19:45:32', 'INSERT', 0, 'Mixer', 'Fotos', 150, 'mixer-1.webp', 'mixer-2.webp', 'mixer-3.webp', NULL),
(16, '2023-06-06 19:46:08', 'INSERT', 0, 'mouse', 'mouse para pc', 50, 'mouse-1.webp', 'mouse-2.webp', 'mouse-3.webp', NULL),
(17, '2023-06-06 19:46:36', 'INSERT', 0, 'tv', '4k', 6000, 'tv-01.webp', 'tv-02.webp', 'tv-03.webp', NULL),
(18, '2023-06-06 23:27:36', 'UPDATE', 9, 'smartphone realme c21Y', 'Ã© do bom', 2500, 'smartphone-1.webp', 'smartphone-2.webp', 'smartphone-3.webp', NULL),
(19, '2023-06-06 23:36:33', 'DELETE', 10, 'CÃ¢mera Super pix', 'Qualidade da boa ', 480, 'camera-1.webp', 'camera-2.webp', 'camera-3.webp', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `produtos_mais_acessados`
-- (See below for the actual view)
--
CREATE TABLE `produtos_mais_acessados` (
`total_prod` varchar(100)
,`acessos` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `produtos_mais_vendidos`
-- (See below for the actual view)
--
CREATE TABLE `produtos_mais_vendidos` (
`total_prod` varchar(100)
,`receita_total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `password`) VALUES
(8, 'e-sell', 'admin@gmail.com', '$2y$10$GkBw55LkDE83vaCxlWmLuOHHEsjnffS/Fg44/AXleL/6HH3q9DUna'),
(9, 'Ana Cristina', 'anaCris@gmail.com', '$2y$10$CbsYK505DhNwDf45KLMJk.2B4R/aZByBM4gRhSobuqCs8TCa9.e.G'),
(10, 'Jose Augusto', 'joseaugusto@gmail.com', '$2y$10$dMSdRdLQfSwhSxijUAQrPOMIQuXWvGxQPpuEdtslg6U2uqZkpw0zy'),
(11, 'Valentina Barros', 'valentinabarros@gmail.com', '$2y$10$HGFOHd8y4309wU4vZ3kyKeoGSk5zx.XyBAQFPzoUNHU.S1604Z17m'),
(12, 'mariazinha', 'mariazinha@gmail.com', '$2y$10$7DwmWgGOpaD7QdR82g1qbOYZ/lYQTEUHvVoiRp0HRbr9mL1SB9cU2'),
(13, 'jordson', 'jordson@hotmail.com', '$2y$10$6asptLH1exIhrd1Db5a72.s/T6CvxDUencOQ.ezCqipOGq/DiUpdK'),
(14, 'MarcosVD94', 'marcos.vinicius.94@hotmail.com.br', '$2y$10$EGZY5CM22x1.I3gxVZRTZOizKMInik0AB.s7Hj9CXa.5qrb2X21AK'),
(15, 'JOSE HENRIQUE BARBOZ', 'henriqueebarbozaa@gmail.com', '$2y$10$xTbv3L7CvWDWim7XY/tcoOcPOa3K/erm51dNI7CJx/pXqqE8FknOa'),
(16, 'Maykon', 'maykonmatta@icloud.com', '$2y$10$Y0z5nrYTYMG34kjTS7Y2zutPYdim5jzfdnuFqAAmbm2joPw7Ybh0G'),
(17, 'ThainÃ¡ ', 'thainabarrosouza@hotmail.com', '$2y$10$C656IL1E4j9ssqV90i.2J.1beu9BAWGkp3TaJGBWmfyFLRS5cnkR.'),
(18, 'Rayane', 'rayane.sousas@icloud.com', '$2y$10$o2sSE3LzZ.u6IdL.wmyWU.9qCmfmsIlqkN2lhNNaH.nMq1hMloQG.'),
(19, 'Ana Cristina ', 'ana.csbarros@gmail.com', '$2y$10$ogGkkS84wAMbDaj1vK810.bPN1l.C1Jfh2Ya/Bow1VGZUdlnExoyG');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` int(10) NOT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `nome`, `preco`, `imagem`) VALUES
(6, 10, 9, 'smartphone China Wall', 1500, 'smartphone-1.webp'),
(9, 13, 11, 'Geladeira Gela tudo', 3699, 'fridge-1.webp'),
(11, 16, 9, 'smartphone realme c21Y', 2500, 'smartphone-1.webp'),
(12, 16, 11, 'Geladeira Gela tudo', 3699, 'fridge-1.webp'),
(13, 16, 12, 'laptop ', 6000, 'laptop-1.webp'),
(14, 16, 13, 'Mixer', 150, 'mixer-1.webp'),
(15, 16, 14, 'mouse', 50, 'mouse-1.webp'),
(17, 15, 12, 'laptop ', 6000, 'laptop-1.webp');

-- --------------------------------------------------------

--
-- Structure for view `produtos_mais_acessados`
--
DROP TABLE IF EXISTS `produtos_mais_acessados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`e-sell`@`localhost` SQL SECURITY DEFINER VIEW `produtos_mais_acessados`  AS SELECT `pedidos`.`total_prod` AS `total_prod`, count(0) AS `acessos` FROM `pedidos` GROUP BY `pedidos`.`total_prod` ORDER BY count(0) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `produtos_mais_vendidos`
--
DROP TABLE IF EXISTS `produtos_mais_vendidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`e-sell`@`localhost` SQL SECURITY DEFINER VIEW `produtos_mais_vendidos`  AS SELECT `pedidos`.`total_prod` AS `total_prod`, sum(`pedidos`.`total_preco`) AS `receita_total` FROM `pedidos` GROUP BY `pedidos`.`total_prod` ORDER BY sum(`pedidos`.`total_preco`) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `contador_pedidos`
--
ALTER TABLE `contador_pedidos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `produtos_log`
--
ALTER TABLE `produtos_log`
  ADD PRIMARY KEY (`log_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `contador_pedidos`
--
ALTER TABLE `contador_pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `produtos_log`
--
ALTER TABLE `produtos_log`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
