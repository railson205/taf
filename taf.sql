-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Nov-2025 às 00:40
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `taf`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicios`
--

CREATE TABLE `exercicios` (
  `id` int(11) NOT NULL,
  `nome_exercicio` varchar(40) DEFAULT NULL,
  `modo_contagem` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `exercicios`
--

INSERT INTO `exercicios` (`id`, `nome_exercicio`, `modo_contagem`) VALUES
(2, 'Abdominal', 'Contagem'),
(3, 'Corrida 2400m', 'Tempo'),
(4, 'Barra', 'Contagem'),
(5, 'Natação 100m', 'Tempo'),
(6, 'Flexão de Braço no Solo', 'Contagem'),
(7, 'Natação 12 minutos', 'Contagem');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faixas_etarias`
--

CREATE TABLE `faixas_etarias` (
  `id` int(11) NOT NULL,
  `nome_grupo` varchar(15) DEFAULT NULL,
  `idade_inicial` int(11) DEFAULT NULL,
  `idade_final` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `faixas_etarias`
--

INSERT INTO `faixas_etarias` (`id`, `nome_grupo`, `idade_inicial`, `idade_final`) VALUES
(1, 'grupo 1', 18, 24),
(2, 'grupo 2', 25, 29),
(3, 'grupo 5', 40, 44),
(4, 'grupo 3', 30, 34),
(5, 'grupo 4', 35, 39),
(6, 'grupo 6', 45, 49),
(7, 'grupo 7', 50, 54),
(9, 'grupo 8', 55, 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `faixa_id` int(11) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `valor_nota` float DEFAULT NULL,
  `exercicio_id` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `notas`
--

INSERT INTO `notas` (`id`, `faixa_id`, `sexo`, `valor_nota`, `exercicio_id`, `indice`) VALUES
(2, 1, 'Masculino', 0.5, 2, 16),
(3, 1, 'Masculino', 0.5, 3, 980),
(4, 1, 'Masculino', 1, 2, 18),
(5, 1, 'Masculino', 1, 3, 960),
(6, 2, 'Masculino', 0.5, 3, 1000),
(7, 2, 'Masculino', 1, 3, 980),
(8, 3, 'Masculino', 0.5, 3, 1060),
(9, 3, 'Masculino', 1, 3, 1040),
(10, 1, 'Masculino', 1.5, 3, 940),
(11, 1, 'Masculino', 2, 3, 920),
(12, 1, 'Masculino', 2.5, 3, 900),
(13, 1, 'Masculino', 3, 3, 880),
(14, 1, 'Masculino', 4, 3, 860),
(15, 1, 'Masculino', 4.5, 3, 840),
(16, 5, 'Masculino', 6, 6, 29),
(17, 1, 'Masculino', 3, 6, 26),
(19, 1, 'Feminino', 2, 3, 1080);

-- --------------------------------------------------------

--
-- Estrutura da tabela `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `exercicio_id` int(11) DEFAULT NULL,
  `indice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `resultados`
--

INSERT INTO `resultados` (`id`, `usuario_id`, `exercicio_id`, `indice_id`) VALUES
(1, 1, 3, 3),
(2, 1, 2, 4),
(3, 2, 3, 8),
(4, 3, 3, 19);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `data_de_nascimento` date DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `matricula` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `data_de_nascimento`, `sexo`, `matricula`) VALUES
(1, 'teste a', '2002-05-07', 'Masculino', '12345'),
(2, 'rafael guimarães', '1983-05-05', 'Masculino', '1583'),
(3, 'teste mulher', '2002-05-07', 'Feminino', '14789');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `exercicios`
--
ALTER TABLE `exercicios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `faixas_etarias`
--
ALTER TABLE `faixas_etarias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faixa_id` (`faixa_id`),
  ADD KEY `exercicio_id` (`exercicio_id`);

--
-- Índices para tabela `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `exercicio_id` (`exercicio_id`),
  ADD KEY `indice_id` (`indice_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `exercicios`
--
ALTER TABLE `exercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `faixas_etarias`
--
ALTER TABLE `faixas_etarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`faixa_id`) REFERENCES `faixas_etarias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`exercicio_id`) REFERENCES `exercicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultados_ibfk_2` FOREIGN KEY (`exercicio_id`) REFERENCES `exercicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultados_ibfk_3` FOREIGN KEY (`indice_id`) REFERENCES `notas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
