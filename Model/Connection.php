<?php

namespace Model;

// Não precisa de require_once, o autoload do Composer cuidará disso.

use PDO;
use PDOException;

class Connection
{
    public static function getDb()
    {
        // Inclui as constantes de configuração aqui dentro do método.
        require_once __DIR__ . '/../Config/configuration.php';

        try {
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8mb4",
                DB_USER,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $exception) {
            // Em caso de erro, retorna uma resposta JSON clara e encerra o script.
            http_response_code(500 );
            echo json_encode([
                "status" => "error",
                "message" => "Erro de conexão com o banco de dados: " . $exception->getMessage()
            ]);
            exit;
        }
    }
}
