Com certeza! Você está certo. A melhor forma de garantir a coerência é ter o arquivo final completo, com todos os ajustes aplicados.

Aqui está a versão final e corrigida do seu `README.md`. Ela foi ajustada para refletir a forma como a sua API funciona na prática (chamando o `index.php` diretamente), o que a torna 100% precisa e à prova de erros para qualquer pessoa que for usá-la.

---

### **Arquivo: `README.md` (Versão Final Corrigida)**

**Ação:** Copie e cole todo o conteúdo abaixo diretamente no seu arquivo `README.md`.

```markdown
# Documentação da API de Componentes de PC

## Visão Geral

Bem-vindo à documentação oficial da API de Componentes de PC. Esta é uma API RESTful construída em PHP, projetada para gerenciar um catálogo de componentes de computador. A API permite a manipulação completa dos recursos de **Produtos** e **Categorias** através de operações CRUD (Create, Read, Update, Delete).

A arquitetura segue as melhores práticas, utilizando `namespaces`, `autoload` do Composer, uma estrutura Modelo-Controlador e um banco de dados relacional com chaves estrangeiras para garantir a integridade dos dados.

---

## Guia de Instalação e Configuração

### Requisitos

-   Um ambiente de servidor local como [XAMPP](https://www.apachefriends.org/index.html) (com Apache e MySQL em execução).
-   PHP 8.0 ou superior.
-   [Composer](https://getcomposer.org/) para gerenciamento de dependências.
-   Uma ferramenta de teste de API, como [Insomnia](https://insomnia.rest/) ou [Postman](https://www.postman.com/).

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
```

### 2. Configuração do Projeto

1.  Clone ou baixe este repositório para a sua pasta `C:/xampp/htdocs/API_PC`.
2.  Abra um terminal na raiz do projeto (`API_PC`).
3.  Execute o comando `composer install` ou `composer dump-autoload -o` para gerar os arquivos de autoload.
4.  Verifique o arquivo `Config/configuration.php` e, se necessário, ajuste as credenciais do seu banco de dados.

---

## Guia de Uso da API (Endpoints)

A URL base para todas as requisições é o arquivo `index.php` do seu projeto. Os parâmetros de ID são passados via `query string` (ex: `?id=1`).

**URL Base:** `http://localhost/API_PC/`

### **Recurso: Produtos**

Este recurso representa os componentes de hardware no nosso catálogo.

---

#### **`POST` (Criar um novo produto)**

Adiciona um novo componente ao banco de dados.

-   **URL:** `http://localhost/API_PC/`
-   **Parâmetros do Corpo (JSON):**
    -   `nome` (string, **Obrigatório**): O nome do produto.
    -   `categoria_id` (integer, **Obrigatório**): O ID da categoria à qual o produto pertence.
    -   `preco` (number, **Obrigatório**): O preço do produto.
    -   `estoque` (integer, Opcional): A quantidade em estoque. Padrão: `0`.
    -   `tdp`, `vram`, `bits`, `ghz`, `cores`, `threads` (string, Opcional): Atributos específicos do componente.

-   **Exemplo de Requisição:**
    ```json
    {
        "nome": "NVIDIA GeForce RTX 4070",
        "categoria_id": 2,
        "preco": 4500.00,
        "estoque": 10,
        "tdp": "200W",
        "vram": "12GB",
        "bits": "192-bit"
    }
    ```

---

#### **`GET` (Listar todos os produtos)**

Retorna uma lista com um resumo de todos os produtos no catálogo.

-   **URL:** `http://localhost/API_PC/`
-   **Resposta de Sucesso (`200 OK`):** Um array de objetos, onde cada objeto é um produto.

---

#### **`GET` (Buscar um produto específico)**

Retorna os detalhes completos de um único produto, especificado pelo seu ID.

-   **URL:** `http://localhost/API_PC/?id=1`
-   **Parâmetros da URL:**
    -   `id` (integer, **Obrigatório**): O ID único do produto a ser buscado.

---

#### **`PUT` (Atualizar um produto)**

Modifica as informações de um produto existente.

-   **URL:** `http://localhost/API_PC/?id=1`
-   **Parâmetros da URL:**
    -   `id` (integer, **Obrigatório**): O ID do produto a ser atualizado.
-   **Parâmetros do Corpo (JSON):** Envie apenas os campos que deseja alterar.
    ```json
    {
        "preco": 4250.75,
        "estoque": 8
    }
    ```

---

#### **`DELETE` (Deletar um produto)**

Remove permanentemente um produto do banco de dados.

-   **URL:** `http://localhost/API_PC/index.php?id=1`
-   **Parâmetros da URL:**
    -   `id` (integer, **Obrigatório**): O ID do produto a ser deletado.

---
---
