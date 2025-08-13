<?php

// --- CABEÇALHOS OBRIGATÓRIOS ---
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Responde à requisição pre-flight OPTIONS do CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// --- AUTOLOAD DO COMPOSER ---
// Carrega todas as nossas classes (Controller, Model, etc.) automaticamente.
require __DIR__ . '/vendor/autoload.php';

// --- ROTEAMENTO ---
// Analisa a URL para determinar o recurso e o ID
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

// Ignora o nome da pasta do projeto se a API não estiver na raiz do domínio
// Ajuste 'API_PC' se o nome da sua pasta for diferente.
if (isset($uri[0]) && strtolower($uri[0]) === strtolower('API_PC')) {
    array_shift($uri);
}

$resource = $uri[0] ?? null;
$id = $uri[1] ?? null;

// Direciona a requisição para o controlador apropriado
switch ($resource) {
    case 'products':
        (new Controller\ProductController())->handleRequest($_SERVER['REQUEST_METHOD'], $id);
        break;
    case 'categories':
        // Exemplo para quando você criar o controlador de categorias
        // (new Controller\CategoryController())->handleRequest($_SERVER['REQUEST_METHOD'], $id);
        http_response_code(501 ); // Not Implemented
        echo json_encode(["message" => "Endpoint de categorias ainda não implementado."]);
        break;
    default:
        http_response_code(404 ); // Not Found
        echo json_encode(["message" => "Endpoint não encontrado. Use /products ou /categories."]);
        break;
}
