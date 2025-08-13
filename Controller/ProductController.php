<?php

namespace Controller;

use Model\Connection;
use Model\Product;
use PDO;

class ProductController
{
    /**
     * Ponto de entrada principal para o controlador.
     * Analisa o método HTTP e o ID da URL para chamar a função apropriada.
     */
    public function handleRequest($method, $id = null)
    {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getOne($id);
                } else {
                    $this->getAll();
                }
                break;
            case 'POST':
                $this->create();
                break;
            case 'PUT':
                // AQUI ESTÁ A MUDANÇA: Verifica se o ID foi passado na URL para o PUT.
                if ($id) {
                    $this->update($id);
                } else {
                    $this->sendResponse(400, ["message" => "ID do produto não fornecido na URL para atualização. Ex: /products/1"]);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->delete($id);
                } else {
                    $this->sendResponse(400, ["message" => "ID do produto não fornecido na URL para exclusão. Ex: /products/1"]);
                }
                break;
            default:
                $this->sendResponse(405, ["message" => "Método não permitido."]);
                break;
        }
    }

    /**
     * Envia uma resposta JSON padronizada.
     */
    private function sendResponse($statusCode, $data)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode );
        echo json_encode($data);
    }

    /**
     * Lista todos os produtos.
     */
    private function getAll()
    {
        $db = Connection::getDb();
        $productModel = new Product($db);
        $products = $productModel->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $this->sendResponse(200, $products);
    }

    /**
     * Busca um único produto pelo ID.
     */
    private function getOne($id)
    {
        $db = Connection::getDb();
        $productModel = new Product($db);
        $productModel->id = $id;
        $product = $productModel->readOne()->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $this->sendResponse(200, $product);
        } else {
            $this->sendResponse(404, ["message" => "Produto não encontrado."]);
        }
    }

    /**
     * Cria um novo produto.
     */
    private function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!$data || empty($data->nome) || !isset($data->categoria_id) || !isset($data->preco)) {
            $this->sendResponse(400, ["message" => "Dados incompletos. 'nome', 'categoria_id' e 'preco' são obrigatórios."]);
            return;
        }

        $db = Connection::getDb();
        $productModel = new Product($db);

        $productModel->nome = $data->nome;
        $productModel->categoria_id = $data->categoria_id;
        $productModel->preco = $data->preco;
        $productModel->estoque = $data->estoque ?? 0;
        $productModel->tdp = $data->tdp ?? null;
        $productModel->vram = $data->vram ?? null;
        $productModel->bits = $data->bits ?? null;
        $productModel->ghz = $data->ghz ?? null;
        $productModel->cores = $data->cores ?? null;
        $productModel->threads = $data->threads ?? null;

        if ($productModel->create()) {
            $this->sendResponse(201, ["message" => "Produto criado com sucesso."]);
        } else {
            $this->sendResponse(500, ["message" => "Não foi possível criar o produto."]);
        }
    }

    /**
     * Atualiza um produto existente.
     * AGORA RECEBE O ID COMO PARÂMETRO DA URL.
     */
    private function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        // Validação: O corpo JSON não pode estar vazio e deve ter pelo menos o nome.
        if (!$data || empty($data->nome)) {
            $this->sendResponse(400, ["message" => "Dados incompletos. O 'nome' do produto é obrigatório no corpo da requisição."]);
            return;
        }

        $db = Connection::getDb();
        $productModel = new Product($db);
        
        // O ID vem da URL, não mais do JSON.
        $productModel->id = $id;

        $stmt = $productModel->readOne();
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingProduct) {
            $this->sendResponse(404, ["message" => "Produto não encontrado com o ID fornecido."]);
            return;
        }

        $productModel->nome = $data->nome ?? $existingProduct['nome'];
        $productModel->categoria_id = $data->categoria_id ?? $existingProduct['categoria_id'];
        $productModel->preco = $data->preco ?? $existingProduct['preco'];
        $productModel->estoque = $data->estoque ?? $existingProduct['estoque'];
        $productModel->tdp = $data->tdp ?? $existingProduct['tdp'];
        $productModel->vram = $data->vram ?? $existingProduct['vram'];
        $productModel->bits = $data->bits ?? $existingProduct['bits'];
        $productModel->ghz = $data->ghz ?? $existingProduct['ghz'];
        $productModel->cores = $data->cores ?? $existingProduct['cores'];
        $productModel->threads = $data->threads ?? $existingProduct['threads'];

        if ($productModel->update()) {
            $this->sendResponse(200, ["message" => "Produto atualizado com sucesso."]);
        } else {
            $this->sendResponse(200, ["message" => "Nenhuma alteração de dados foi detectada."]);
        }
    }

    /**
     * Deleta um produto pelo ID.
     */
    private function delete($id)
    {
        $db = Connection::getDb();
        $productModel = new Product($db);
        $productModel->id = $id;

        if ($productModel->delete()) {
            $this->sendResponse(200, ["message" => "Produto excluído com sucesso."]);
        } else {
            $this->sendResponse(404, ["message" => "Não foi possível excluir o produto. Verifique se o ID existe."]);
        }
    }
}
