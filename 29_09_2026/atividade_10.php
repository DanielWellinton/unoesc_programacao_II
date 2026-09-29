<?php

class ConexaoBD {
    private $dsn = 'mysql:host=db;port=3306;dbname=mydatabase;charset=utf8mb4';
    private $username = 'myuser';
    private $password = 'mypassword';

    private function conectar() {
        try {
            $pdo = new PDO($this->dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConexao() {
        return $this->conectar();
    }
}

/***
 * Suba os containers: docker-compose up -d --build
 * Ou certifique-se de ter o pdo_mysql
 * */ 
$db = new ConexaoBD();
$conexao = $db->getConexao();

if ($conexao) {
    echo "Conexão com o MySQL estabelecida com sucesso!\n";
}