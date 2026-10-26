-- ============================================================
-- Teams - loja virtual de jogos digitais (Trabalho 3)
-- Export MariaDB: estrutura + dados iniciais
-- Para importar: mysql -u root -p < sql/database.sql
-- (ou phpMyAdmin > Importar)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `teams_db`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `teams_db`;

SET NAMES utf8mb4;

-- ------------------------------------------------------------
-- Tabela de usuários (senha armazenada como hash do password_hash)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome`            VARCHAR(100) NOT NULL,
  `login`           VARCHAR(30)  NOT NULL,
  `senha_hash`      VARCHAR(255) NOT NULL,
  `cpf`             CHAR(11)     NOT NULL,
  `data_nascimento` DATE         NOT NULL,
  `email`           VARCHAR(100) NOT NULL,
  `criado_em`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuarios_login` (`login`),
  UNIQUE KEY `uq_usuarios_cpf`   (`cpf`),
  UNIQUE KEY `uq_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Tabela de produtos
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `id`     INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nome`   VARCHAR(100)  NOT NULL,
  `preco`  DECIMAL(10,2) NOT NULL,
  `imagem` VARCHAR(255)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produtos` (`id`, `nome`, `preco`, `imagem`) VALUES
  (1, 'Pathologic 2',          101.99, 'img/pathologic2.jpg'),
  (2, 'Red Dead Redemption 2', 299.90, 'img/rdr2.jpg'),
  (3, 'Dead Cells',             47.49, 'img/dead_cells.jpg'),
  (4, 'Portal',                 32.99, 'img/portal.jpg'),
  (5, 'Hollow Knight',          46.99, 'img/hollow_knight.jpg'),
  (6, 'Obra Dinn',              59.99, 'img/obra_dinn.jpg'),
  (7, 'Blue Prince',            88.99, 'img/blue_prince.jpg'),
  (8, 'Deep Rock Galactic',     73.99, 'img/deep_rock_galactic.jpg'),
  (9, 'Stardew Valley',         23.99, 'img/stardew.jpg');
