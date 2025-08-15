<?php

// Carrega todas as nossas classes via Composer
require __DIR__ . '/vendor/autoload.php';

// Usa as classes que vamos precisar
use Controller\ProductController;
use Model\Connection;

// --- CABEÇALHOS ESSENCIAIS PARA A API ---
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Lida com a requisição pré-voo (preflight) do navegador
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200 );
    exit;
}

// --- ROTEADOR SIMPLES (ESTILO API DO SEU AMIGO) ---

// Pega o método da requisição (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Pega o ID da URL, se ele existir (ex: ?id=1)
$id = $_GET['id'] ?? null;

// Instancia o nosso controlador
$controller = new ProductController();

// --- LÓGICA DE DECISÃO ---

if ($method === 'GET' && $id === null) {
    // Se for GET e não tiver ID, lista todos os produtos.
    $controller->handleRequest('GET');

} elseif ($method === 'GET' && $id !== null) {
    // Se for GET e tiver um ID, busca um produto específico.
    $controller->handleRequest('GET', $id);

} elseif ($method === 'POST') {
    // Se for POST, cria um novo produto.
    $controller->handleRequest('POST');

} elseif ($method === 'PUT' && $id !== null) {
    // Se for PUT e tiver um ID, atualiza o produto.
    $controller->handleRequest('PUT', $id);

} elseif ($method === 'DELETE' && $id !== null) {
    // Se for DELETE e tiver um ID, deleta o produto.
    $controller->handleRequest('DELETE', $id);

} else {
    // Se nenhuma das condições acima for atendida, a rota é inválida.
    http_response_code(404 );
    echo json_encode(["message" => "Rota não encontrada ou ID ausente para a operação."]);
}
