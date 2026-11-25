<?php

namespace Biblioteca\Infrastructure;

use InvalidArgumentException;
use PDO;

final class Conexao
{
    public static function abrir(): PDO
    {
        $dsn = ['mysql' => 'mysql:host=db;port=3306;dbname=biblioteca_orm;charset=utf8mb4'];
        if (!isset($dsn['mysql'])) throw new InvalidArgumentException('Driver inválido');
        return new PDO($dsn['mysql'], getenv('DB_USER'), getenv('DB_PASSWORD'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}