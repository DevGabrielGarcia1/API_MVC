-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/06/2024 às 21:57
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
  `nome` varchar(50) DEFAULT NULL,
  `CPF` varchar(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `CPF`, `data_nascimento`, `telefone`, `email`) VALUES
(1, 'Cliente1', '4354634657', '2000-07-26', '2354326645', 'teste@test.test'),
(2, 'Lucas Almeida', '234.567.890', '1992-01-12', '(21) 99876-5432', 'lucas.almeida@example.com'),
(3, 'Juliana Santos', '345.678.901', '1987-07-05', '(11) 98765-4321', 'juliana.santos@example.com'),
(4, 'Felipe Andrade', '456.789.012', '1995-11-23', '(31) 91234-5678', 'felipe.andrade@example.com'),
(5, 'Renata Ferreira', '567.890.123', '1983-02-16', '(41) 93456-7890', 'renata.ferreira@example.com'),
(6, 'Tiago Moreira', '678.901.234', '1990-09-08', '(51) 95678-1234', 'tiago.moreira@example.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(3) NOT NULL,
  `id_imovel` int(3) DEFAULT NULL,
  `id_cliente` int(3) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`id`, `id_imovel`, `id_cliente`, `data_inicio`, `data_fim`, `forma_pagamento`) VALUES
(2, 5, 1, '2024-07-01', NULL, 'Boleto Bancário'),
(3, 7, 2, '2024-10-05', NULL, 'Pix'),
(4, 11, 5, '2024-09-20', NULL, 'Transferência Bancária');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imoveis`
--

CREATE TABLE `imoveis` (
  `id` int(3) NOT NULL,
  `id_proprietario` int(3) DEFAULT NULL,
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

INSERT INTO `imoveis` (`id`, `id_proprietario`, `tipo_imovel`, `endereco`, `cidade`, `estado`, `CEP`, `valor_aluguel`, `area`, `quartos`, `banheiros`, `vagas_garagem`, `descricao`, `active`) VALUES
(5, 9, 'Apartamento', 'Rua das Flores, 123', 'São Paulo', 'SP', '01001-00', 1500.00, 80.00, 2, 1, 1, 'Apartamento bem localizado, próximo ao metrô e comércio.', 1),
(6, 10, 'Casa', 'Avenida Brasil, 456', 'Rio de Janeiro', 'RJ', '20031-00', 2500.00, 120.00, 3, 2, 2, 'Casa ampla com quintal, ideal para famílias grandes.', 1),
(7, 11, 'Kitnet', 'Rua da Paz, 789', 'Belo Horizonte', 'MG', '30140-00', 800.00, 30.00, 1, 1, 0, 'Kitnet aconchegante no centro da cidade.', 1),
(9, 12, 'Apartamento', 'Rua das Palmeiras, 123', 'Curitiba', 'PR', '80010-00', 1800.00, 90.00, 3, 2, 1, 'Apartamento espaçoso, com excelente iluminação natural.', 1),
(10, 13, 'Casa', 'Avenida Paulista, 456', 'São Paulo', 'SP', '01310-00', 3000.00, 150.00, 4, 3, 2, 'Casa de alto padrão em região nobre da cidade.', 1),
(11, 14, 'Kitnet', 'Rua do Sol, 789', 'Salvador', 'BA', '40020-00', 750.00, 35.00, 1, 1, 0, 'Kitnet mobiliada, pronta para morar.', 1),
(12, 15, 'Cobertura', 'Rua das Estrelas, 101', 'Porto Alegre', 'RS', '90030-00', 5000.00, 200.00, 4, 4, 3, 'Cobertura com vista panorâmica da cidade e piscina privativa.', 1),
(13, 16, 'Chácara', 'Estrada do Campo, Km 5', 'Campinas', 'SP', '13090-00', 2200.00, 500.00, 3, 2, 4, 'Chácara com área verde, ideal para lazer e descanso.', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietarios`
--

CREATE TABLE `proprietarios` (
  `id` int(3) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `CPF` varchar(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `proprietarios`
--

INSERT INTO `proprietarios` (`id`, `nome`, `CPF`, `data_nascimento`, `telefone`, `email`) VALUES
(9, 'João Silva', '123.456.789', '1980-04-15', '(11) 98765-4321', 'joao.silva@example.com'),
(10, 'Maria Oliveira', '987.654.321', '1975-09-22', '(21) 91234-5678', 'maria.oliveira@example.com'),
(11, 'Carlos Souza', '456.123.789', '1985-12-08', '(31) 99876-5432', 'carlos.souza@example.com'),
(12, 'Ana Pereira', '321.654.987', '1990-05-30', '(41) 93456-7890', 'ana.pereira@example.com'),
(13, 'Bruno Costa', '159.753.486', '1982-03-18', '(51) 95678-1234', 'bruno.costa@example.com'),
(14, 'Claudia Mendes', '951.357.852', '1978-11-25', '(71) 92345-6789', 'claudia.mendes@example.com'),
(15, 'Diego Rocha', '789.123.456', '1995-02-10', '(81) 91234-5678', 'diego.rocha@example.com'),
(16, 'Fernanda Lima', '852.963.741', '1988-08-12', '(91) 93456-7890', 'fernanda.lima@example.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(3) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `senha` varchar(64) DEFAULT NULL,
  `permissao` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `senha`, `permissao`) VALUES
(1, 'admin', 'admin', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CPF` (`CPF`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proprietario` (`id_proprietario`);

--
-- Índices de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `imoveis`
--
ALTER TABLE `imoveis`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_ibfk_1` FOREIGN KEY (`id_imovel`) REFERENCES `imoveis` (`id`),
  ADD CONSTRAINT `contratos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Restrições para tabelas `imoveis`
--
ALTER TABLE `imoveis`
  ADD CONSTRAINT `imoveis_ibfk_1` FOREIGN KEY (`id_proprietario`) REFERENCES `proprietarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
