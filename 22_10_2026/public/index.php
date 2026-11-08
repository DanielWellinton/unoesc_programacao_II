<?php

// Importação das configurações, models e repositórios
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/Model/Autor.php';
require_once __DIR__ . '/../src/Model/Livro.php';
require_once __DIR__ . '/../src/Repository/AutorRepository.php';
require_once __DIR__ . '/../src/Repository/LivroRepository.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel de Testes - Projeto Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; color: #333; }
        h1, h2 { color: #2c3e50; }
        .card { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; font-weight: bold; }
        .error { color: #c0392b; font-weight: bold; }
        .info { color: #2980b9; }
    </style>
</head>
<body>

<div class="card">
    <h1>Painel de Testes - Banco de Dados II (MySQL 8.x)</h1>
    <p>Projeto Integrador: <strong>Biblioteca</strong></p>
    <hr>

    <?php
    try {
        // 1. Conexão via PDO
        $pdo = Database::conectar('mysql');
        echo "<p class='success'>✔ Conexão com o banco de dados estabelecida com sucesso!</p>";

        $autorRepo = new AutorRepository($pdo);
        $livroRepo = new LivroRepository($pdo);

        // 2. Teste de Inserção de Autor (Exercício 1)
        try {
            $novoAutorId = $autorRepo->create("Clarice Lispector", "Brasileira");
            echo "<p class='success'>✔ Autor cadastrado com sucesso! ID atribuído: {$novoAutorId}</p>";
        } catch (Exception $e) {
            echo "<p class='info'>ℹ Nota no cadastro de autor: " . $e->getMessage() . "</p>";
            // Utiliza um ID existente para prosseguir com os testes caso já esteja cadastrado
            $novoAutorId = 1; 
        }

        // 3. Teste de Inserção de Livro (Exercício 2)
        try {
            $livroRepo->create(
                "A Hora da Estrela", 
                "9788532512349", 
                1977, 
                39.90, 
                $novoAutorId, 
                10
            );
            echo "<p class='success'>✔ Livro 'A Hora da Estrela' cadastrado com referência válida ao autor ID {$novoAutorId}!</p>";
        } catch (Exception $e) {
            echo "<p class='info'>ℹ Nota no cadastro de livro (possível ISBN duplicado): " . $e->getMessage() . "</p>";
        }

    } catch (Exception $e) {
        echo "<p class='error'>❌ Erro Crítico: " . $e->getMessage() . "</p>";
    }
    ?>
</div>

<div class="card">
    <h2>Acervo de Livros (Consulta Relacional com LEFT JOIN)</h2>
    
    <?php
    try {
        // Utilizando o método do repositório para listar com autores
        $livrosComAutores = $livroRepo->listarComAutores();

        if ($livrosComAutores) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>ISBN</th><th>Ano</th><th>Preço</th><th>Qtd</th></tr>";
            foreach ($livrosComAutores as $item) {
                $autorNome = $item['autor_nome'] ?? '<span style="color: gray; font-style: italic;">Sem Autor</span>';
                echo "<tr>";
                echo "<td>{$item['id']}</td>";
                echo "<td><strong>{$item['titulo']}</strong></td>";
                echo "<td>{$autorNome}</td>";
                echo "<td>{$item['isbn']}</td>";
                echo "<td>{$item['ano_publicacao']}</td>";
                echo "<td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>";
                echo "<td>{$item['quantidade']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum registro encontrado na tabela de livros.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>Erro ao carregar a listagem: " . $e->getMessage() . "</p>";
    }
    ?>
</div>

</body>
</html>