<?php

require_once __DIR__ . '/../config/Database.php';

try {
    $pdo = Database::conectar('mysql');
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo 'Não foi possível acessar os dados.';
}
