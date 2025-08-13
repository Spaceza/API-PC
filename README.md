# API de Componentes de PC

Bem-vindo à API de Componentes de PC. Esta é uma API RESTful construída em PHP puro, projetada para gerenciar um catálogo de componentes de computador, como processadores, placas de vídeo, e mais.

A API permite realizar operações CRUD (Create, Read, Update, Delete) completas para dois recursos principais: **Produtos** e **Categorias**.

## Funcionalidades

- **Gerenciamento de Produtos:** Crie, liste, visualize, atualize e delete componentes de hardware.
- **Gerenciamento de Categorias:** Crie e visualize categorias para organizar os produtos.
- **Arquitetura Moderna:** Utiliza `namespaces`, `autoload` do Composer e uma estrutura Modelo-Controlador para organização e manutenibilidade.
- **Segurança:** Implementa sanitização de entradas para prevenir ataques XSS e validação de dados.
- **Banco de Dados Relacional:** Usa chaves estrangeiras para garantir a integridade dos dados entre produtos e categorias.

---

## Requisitos

- [XAMPP](https://www.apachefriends.org/index.html ) ou um ambiente de servidor similar (Apache, MySQL, PHP).
- PHP 8.0 ou superior.
- [Composer](https://getcomposer.org/ ) para gerenciamento de dependências.
- Uma ferramenta de teste de API, como [Insomnia](https://insomnia.rest/ ) ou [Postman](https://www.postman.com/ ).

---

## Guia de Instalação e Configuração

Siga estes passos para configurar o ambiente e rodar a API localmente.

### 1. Configuração do Servidor Apache

Para que as URLs amigáveis (ex: `/products/1`) funcionem, o módulo `mod_rewrite` do Apache precisa estar ativado.

1.  Abra o painel de controle do XAMPP.
2.  Clique em `Config` na linha do Apache e abra o arquivo `httpd.conf`.
3.  Procure (Ctrl+F ) pela linha `#LoadModule rewrite_module modules/mod_rewrite.so` e remova o `#` do início.
4.  Procure pelo bloco `<Directory "C:/xampp/htdocs">`. Dentro dele, encontre a linha `AllowOverride None` e mude para `AllowOverride All`.
5.  Salve o arquivo `httpd.conf` e **reinicie o Apache** no painel do XAMPP.

### 2. Configuração do Banco de Dados

1.  Abra o **phpMyAdmin** (`Admin` na linha do MySQL no XAMPP ).
2.  Vá para a aba **SQL**.
3.  Copie e cole o conteúdo do arquivo `database.sql` (ou o script SQL fornecido) e execute-o. Isso criará o banco de dados `api_pc` e as tabelas `products` e `categories`.

### 3. Configuração do Projeto

1.  Clone ou baixe este repositório para a sua pasta `C:/xampp/htdocs/API_PC`.
2.  Abra um terminal na raiz do projeto (`API_PC`).
3.  Execute o comando `composer install` ou `composer dump-autoload -o` para gerar os arquivos de autoload.
4.  Renomeie o arquivo `Config/configuration.php.example` para `Config/configuration.php` e, se necessário, ajuste as credenciais do seu banco de dados.

Sua API está pronta para ser usada!

---

## Guia da API (Endpoints)

A URL base para todas as requisições é: `http://localhost/API_PC`

### Produtos (`/products` )

#### 1. Listar todos os produtos

- **Método:** `GET`
- **Endpoint:** `/products`
- **Resposta de Sucesso (200 OK):**
  ```json
  [
      {
          "nome_categoria": "Processador",
          "id": 1,
          "nome": "AMD Ryzen 5 5600",
          "categoria_id": 1,
          "preco": "750.50",
          "estoque": 15,
          "created_at": "2025-08-13 15:00:00"
      }
  ]
