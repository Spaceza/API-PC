# Documentação da API de Componentes de PC

## Visão Geral

Bem-vindo à documentação oficial da API de Componentes de PC. Esta é uma API RESTful construída em PHP, projetada para gerenciar um catálogo de componentes de computador. A API permite a manipulação completa dos recursos de **Produtos** e **Categorias** através de operações CRUD (Create, Read, Update, Delete).

A arquitetura segue as melhores práticas, utilizando `namespaces`, `autoload` do Composer, uma estrutura Modelo-Controlador e um banco de dados relacional com chaves estrangeiras para garantir a integridade dos dados.

---

## Guia de Instalação e Configuração

### Requisitos

-   Um ambiente de servidor local como [XAMPP](https://www.apachefriends.org/index.html ) (com Apache e MySQL em execução).
-   PHP 8.0 ou superior.
-   [Composer](https://getcomposer.org/ ) para gerenciamento de dependências.
-   Uma ferramenta de teste de API, como [Insomnia](https://insomnia.rest/ ) ou [Postman](https://www.postman.com/ ).

### 1. Configuração do Banco de Dados

Aqui está o SQL do banco de dados para o funcionamento correto. Execute este script na aba **SQL** do seu phpMyAdmin para criar o banco de dados `api_pc` e as tabelas `products` e `categories` com a estrutura necessária.

```sql
-- Apaga o banco de dados antigo, se ele existir, para começar do zero.
DROP DATABASE IF EXISTS `api_pc`;

-- Cria o novo banco de dados com a codificação de caracteres correta.
CREATE DATABASE `api_pc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Seleciona o banco de dados recém-criado para uso.
USE `api_pc`;

-- Estrutura da tabela `categories`
CREATE TABLE `categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `products`
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `categoria_id` INT(11) NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `estoque` INT(11) NULL DEFAULT 0,
  `tdp` VARCHAR(50) NULL DEFAULT NULL,
  `vram` VARCHAR(50) NULL DEFAULT NULL,
  `bits` VARCHAR(50) NULL DEFAULT NULL,
  `ghz` VARCHAR(50) NULL DEFAULT NULL,
  `cores` VARCHAR(50) NULL DEFAULT NULL,
  `threads` VARCHAR(50) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Adiciona a restrição de chave estrangeira (FOREIGN KEY)
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- Insere algumas categorias iniciais para teste
INSERT INTO `categories` (`id`, `nome`) VALUES
(1, 'Processador'),
(2, 'Placa de Vídeo'),
(3, 'Memória RAM'),
(4, 'Armazenamento SSD');
