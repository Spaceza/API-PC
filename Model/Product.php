<?php

namespace Model;

use PDO;

class Product
{
    // Propriedades do banco de dados e da tabela
    private $conn;
    private $table_name = "products";

    // Propriedades do objeto Produto
    public $id;
    public $nome;
    public $categoria_id;
    public $preco;
    public $estoque;
    public $tdp;
    public $vram;
    public $bits;
    public $ghz;
    public $cores;
    public $threads;
    public $created_at;
    public $updated_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lê todos os produtos do banco de dados.
     * A query foi mantida com o JOIN pois ela está funcionando corretamente no GET ALL.
     */
    public function readAll()
    {
        $query = "SELECT
                    c.nome as nome_categoria,
                    p.id,
                    p.nome,
                    p.categoria_id,
                    p.preco,
                    p.estoque,
                    p.created_at
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c ON p.categoria_id = c.id
                ORDER BY
                    p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lê um único produto pelo ID (versão simplificada para depuração).
     * Esta versão remove o JOIN para garantir que a busca básica funcione.
     */
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincula o ID com o tipo de dado explícito, o que é crucial.
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }

    /**
     * Cria um novo produto no banco de dados.
     */
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, categoria_id, preco, estoque, tdp, vram, bits, ghz, cores, threads) VALUES (:nome, :categoria_id, :preco, :estoque, :tdp, :vram, :bits, :ghz, :cores, :threads)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":estoque", $this->estoque);
        $stmt->bindParam(":tdp", $this->tdp);
        $stmt->bindParam(":vram", $this->vram);
        $stmt->bindParam(":bits", $this->bits);
        $stmt->bindParam(":ghz", $this->ghz);
        $stmt->bindParam(":cores", $this->cores);
        $stmt->bindParam(":threads", $this->threads);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Atualiza um produto existente no banco de dados.
     */
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, categoria_id = :categoria_id, preco = :preco, estoque = :estoque, tdp = :tdp, vram = :vram, bits = :bits, ghz = :ghz, cores = :cores, threads = :threads WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':estoque', $this->estoque);
        $stmt->bindParam(':tdp', $this->tdp);
        $stmt->bindParam(':vram', $this->vram);
        $stmt->bindParam(':bits', $this->bits);
        $stmt->bindParam(':ghz', $this->ghz);
        $stmt->bindParam(':cores', $this->cores);
        $stmt->bindParam(':threads', $this->threads);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Deleta um produto do banco de dados pelo ID.
     */
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
