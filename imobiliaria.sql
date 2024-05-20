-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/05/2024 às 14:20
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `imobiliaria`
--
CREATE DATABASE IF NOT EXISTS `imobiliaria` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `imobiliaria`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(3) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `CPF`, `data_nascimento`, `telefone`, `email`) VALUES
(1, 'Teste', '00000000000', '0000-00-00', '349000000000', 'teste@gmail.com'),
(8, 'Teste', '00011100011', '2024-05-20', '34991999999', 'aaaaaaaaa'),
(9, 'Teste', '0000000000', '0024-05-20', '34567890', '3dfghj');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(3) NOT NULL,
  `id_imovel` int(3) NOT NULL,
  `id_cliente` int(3) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `forma_pagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`id`, `id_imovel`, `id_cliente`, `data_inicio`, `data_fim`, `forma_pagamento`) VALUES
(1, 1, 1, '2024-05-19', '2025-05-19', 'Débito em conta'),
(2, 3, 8, '2024-05-20', '2025-05-20', 'Pix'),
(5, 4, 9, '2024-05-20', '2026-05-20', '20/05/2026');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imoveis`
--

CREATE TABLE `imoveis` (
  `id` int(3) NOT NULL,
  `tipo_imovel` varchar(25) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cidade` varchar(25) DEFAULT NULL,
  `estado` varchar(25) DEFAULT NULL,
  `CEP` varchar(8) DEFAULT NULL,
  `valor_aluguel` decimal(10,2) DEFAULT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `quartos` int(2) DEFAULT NULL,
  `banheiros` int(2) DEFAULT NULL,
  `vagas_garagem` int(2) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `active` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imoveis`
--

INSERT INTO `imoveis` (`id`, `tipo_imovel`, `endereco`, `cidade`, `estado`, `CEP`, `valor_aluguel`, `area`, `quartos`, `banheiros`, `vagas_garagem`, `descricao`, `active`) VALUES
(1, 'Casa', 'rua A', 'Uberaba', 'MG', '000000', 1200.00, 20.00, 2, 2, 2, 'Teste', 1),
(3, 'Apartamento', 'Rua ABC', 'Ribeirão Preto', 'SP', '00000000', 1950.85, 50.00, 3, 2, 2, 'lsudhfdsfksd', 1),
(4, 'Apartamento', 'Rua ABC', 'Ribeirão Preto', 'SP', '00000000', 1950.00, 50.00, 3, 2, 2, 'lsudhfdsfksd', 1),
(5, 'Apartamento', 'Rua ABC', 'Ribeirão Preto', 'SP', '00000000', 1950.95, 50.00, 3, 2, 2, 'lsudhfdsfksd', 1),
(6, 'Apartamento', 'Rua ABC', 'Ribeirão Preto', 'SP', '00000000', 195.50, 50.00, 3, 2, 2, 'lsudhfdsfksd', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

CREATE TABLE `proprietario` (
  `id` int(3) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(2) NOT NULL,
  `username` varchar(15) NOT NULL,
  `senha` varchar(64) DEFAULT NULL,
  `permissao` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `senha`, `permissao`) VALUES
(1, 'admin', 'admin', 0),
(43, 'user', 'user', 1),
(44, 'user2', 'user2', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_imovel` (`id_imovel`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `imoveis`
--
ALTER TABLE `imoveis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `proprietario`
--
ALTER TABLE `proprietario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `imoveis`
--
ALTER TABLE `imoveis`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `proprietario`
--
ALTER TABLE `proprietario`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_ibfk_1` FOREIGN KEY (`id_imovel`) REFERENCES `imoveis` (`id`),
  ADD CONSTRAINT `contratos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
