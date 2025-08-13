# API PC MVC

## Banco de Dados MySQL (api_pc)

### 1. Criar banco
```sql
CREATE DATABASE api_pc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Criar tabela de categorias
```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO categories (nome) VALUES ('placa_video'),('processador');
```

### 3. Criar tabela de produtos
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria_id INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL,
    tdp INT NOT NULL,
    vram INT NULL,
    bits INT NULL,
    ghz DECIMAL(3,2) NULL,
    cores INT NULL,
    threads INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_categoria FOREIGN KEY (categoria_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

### 4. Dados iniciais
```sql
INSERT INTO products (nome,categoria_id,preco,estoque,tdp,vram,bits) VALUES ('GeForce RTX 4060',1,2199.90,5,160,8,128);
INSERT INTO products (nome,categoria_id,preco,estoque,tdp,ghz,cores,threads) VALUES ('Ryzen 5 5600',2,899.90,8,65,3.5,6,12);
```
