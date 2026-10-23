<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/Model/Livro.php';
require_once __DIR__ . '/../src/Repository/LivroRepository.php';

echo "<h2>Painel de Testes - Biblioteca</h2>";

try {
    $pdo = Database::conectar('mysql');
    echo "<p style='color: green;'>✔ Conexão com o banco de dados realizada com sucesso!</p>";

    $repository = new LivroRepository($pdo);

    
    try {
        $repository->create("Arquitetura Limpa", "978-85-508-0460-6", 2019, 99.90, 1, 5);
        echo "<p style='color: green;'>✔ Livro cadastrado com sucesso!</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ " . $e->getMessage() . "</p>";
    }
    

    echo "<h3>05. Listagem de Livros (Ordenados por Título):</h3>";
    $livros = $repository->getAll();
    
    if ($livros) {
        echo "<ul>";
        foreach ($livros as $livro) {
            echo "<li><strong>ID:</strong> {$livro->getId()} | <strong>Título:</strong> {$livro->getTitulo()} | <strong>Ano:</strong> {$livro->getAnoPublicacao()} | <strong>Preço:</strong> R$ {$livro->getPreco()}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum livro cadastrado no momento.</p>";
    }

    $idBusca = 999;
    echo "<h3>06 & 08. Busca por ID (ID: {$idBusca}):</h3>";
    
    $livroEncontrado = $repository->buscarPorId($idBusca);
    if ($livroEncontrado) {
        echo "<p style='color: green;'>✔ Livro encontrado: {$livroEncontrado->getTitulo()}</p>";
    } else {
        echo "<p style='color: blue;'>ℹ Livro com ID {$idBusca} não encontrado (Tratado com sucesso, sem erro fatal).</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Erro Crítico:</strong> " . $e->getMessage() . "</p>";
}