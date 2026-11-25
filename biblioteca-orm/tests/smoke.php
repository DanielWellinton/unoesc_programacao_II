<?php

require_once __DIR__ . '/../autoload.php';

use Biblioteca\Domain\Livro;
use Biblioteca\Domain\Autor;
use Biblioteca\Infrastructure\Conexao;
use Biblioteca\Infrastructure\LivroRepository;
use Biblioteca\Infrastructure\AutorRepository;
use Biblioteca\Infrastructure\RepositoryInterface;

try {

    // =========================================================
    // CONEXÃO COM O BANCO DE DADOS
    // =========================================================

    $pdo = Conexao::abrir();

    echo "============================================\n";
    echo "       TESTE DA BIBLIOTECA ORM\n";
    echo "============================================\n\n";

    echo "Conexão com o banco estabelecida!\n\n";

    $livros = new LivroRepository($pdo);
    $autores = new AutorRepository($pdo);


    // =========================================================
    // EVIDÊNCIA 1 - CADASTRO DE AUTORES E LIVRO
    // IDs GERADOS AUTOMATICAMENTE PELO MYSQL
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 1 - CADASTRO\n";
    echo "============================================\n";

    $autor1 = new Autor('Machado de Assis', 'Brasil');
    $autor2 = new Autor('José de Alencar', 'Brasil');

    $autores->salvar($autor1);
    $autores->salvar($autor2);

    echo "Autores cadastrados com sucesso!\n";
    echo "Autor 1: {$autor1->nome()} | ID: {$autor1->id()}\n";
    echo "Autor 2: {$autor2->nome()} | ID: {$autor2->id()}\n\n";

    $livro = new Livro(
        'Introdução à Programação Orientada a Objetos',
        null,
        2026
    );

    $livros->salvar($livro);

    echo "Livro cadastrado com sucesso!\n";
    echo "Livro: {$livro->titulo()}\n";
    echo "ID gerado pelo MySQL: {$livro->id()}\n\n";


    // =========================================================
    // EVIDÊNCIA 2 - BUSCA DE LIVRO POR ID E HIDRATAÇÃO
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 2 - BUSCA E HIDRATAÇÃO\n";
    echo "============================================\n";

    $livroEncontrado = $livros->buscar($livro->id());

    if ($livroEncontrado === null) {
        throw new RuntimeException('Livro não encontrado.');
    }

    echo "Livro recuperado do banco de dados:\n";
    echo "ID: {$livroEncontrado->id()}\n";
    echo "Título: {$livroEncontrado->titulo()}\n";
    echo "ISBN: " . ($livroEncontrado->isbn() ?? 'Não informado') . "\n";
    echo "Ano de publicação: {$livroEncontrado->anoPublicacao()}\n";
    echo "Tipo do objeto: " . get_class($livroEncontrado) . "\n\n";


    // =========================================================
    // EVIDÊNCIA 3 - ATUALIZAÇÃO E NOVA CONSULTA
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 3 - ATUALIZAÇÃO\n";
    echo "============================================\n";

    $livroEncontrado->alterarTitulo(
        'Programação Orientada a Objetos com PHP'
    );

    $livros->salvar($livroEncontrado);

    echo "Título atualizado e salvo no banco!\n";

    // Nova consulta para comprovar a alteração
    $livroAtualizado = $livros->buscar($livroEncontrado->id());

    if (
        $livroAtualizado === null ||
        $livroAtualizado->titulo() !== 'Programação Orientada a Objetos com PHP'
    ) {
        throw new RuntimeException('A atualização do livro não foi confirmada.');
    }

    echo "Resultado de uma nova consulta:\n";
    echo "ID: {$livroAtualizado->id()}\n";
    echo "Novo título: {$livroAtualizado->titulo()}\n\n";


    // =========================================================
    // EVIDÊNCIA 4 - ASSOCIAÇÃO N:N ENTRE LIVROS E AUTORES
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 4 - ASSOCIAÇÃO DE AUTORES\n";
    echo "============================================\n";

    $livros->associarAutor($livro->id(), $autor1->id());
    $livros->associarAutor($livro->id(), $autor2->id());

    echo "Dois autores associados ao livro!\n";

    $autoresEncontrados = $livros->autoresDoLivro($livro->id());

    // Adiciona os autores à coleção do objeto Livro
    foreach ($autoresEncontrados as $autor) {
        $livroEncontrado->adicionarAutor($autor);
    }

    echo "Autores recuperados do banco:\n";

    foreach ($livroEncontrado->autores() as $autor) {
        echo "- {$autor->nome()} (ID: {$autor->id()})\n";
    }

    echo "Total de autores recuperados: "
        . count($livroEncontrado->autores()) . "\n\n";

    if (count($livroEncontrado->autores()) !== 2) {
        throw new RuntimeException(
            'A associação não recuperou os dois autores esperados.'
        );
    }


    // =========================================================
    // EVIDÊNCIA 5 - POLIMORFISMO
    // MESMO CONTRATO PARA DOIS REPOSITÓRIOS
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 5 - POLIMORFISMO\n";
    echo "============================================\n";

    function consultarPorContrato(
        RepositoryInterface $repositorio,
        int $id
    ): ?object {
        return $repositorio->buscar($id);
    }

    // Utiliza a mesma função para os dois repositórios
    $resultadoLivro = consultarPorContrato(
        $livros,
        $livro->id()
    );

    $resultadoAutor = consultarPorContrato(
        $autores,
        $autor1->id()
    );

    echo "Consulta utilizando o mesmo contrato:\n";

    echo "Livro: {$resultadoLivro->titulo()}\n";
    echo "Classe retornada: " . get_class($resultadoLivro) . "\n";

    echo "Autor: {$resultadoAutor->nome()}\n";
    echo "Classe retornada: " . get_class($resultadoAutor) . "\n\n";


    // =========================================================
    // EVIDÊNCIA 6 - TRANSAÇÃO E ROLLBACK
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 6 - TRANSAÇÃO E ROLLBACK\n";
    echo "============================================\n";

    $idRollback = null;
    $erroEsperado = false;

    $pdo->beginTransaction();

    try {

        $livroRollback = new Livro(
            'Livro para teste de rollback ' . uniqid(),
            null,
            2026
        );

        // Primeiro cadastro dentro da transação
        $livros->salvar($livroRollback);

        $idRollback = $livroRollback->id();

        echo "Livro cadastrado temporariamente.\n";
        echo "ID: {$idRollback}\n";

        echo "Tentando associar a um autor inexistente...\n";

        // Deve provocar erro de chave estrangeira
        $livros->associarAutor(
            $idRollback,
            999999999
        );

        // Se chegou aqui, a associação não provocou erro
        $pdo->commit();

        echo "FALHA: a associação deveria ter sido rejeitada.\n";

    } catch (PDOException $e) {

        $erroEsperado = true;

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo "Erro esperado capturado!\n";
        echo "Motivo: associação com autor inexistente.\n";
        echo "Código SQL: {$e->getCode()}\n";
        echo "Rollback executado.\n";
    }

    if (!$erroEsperado) {
        throw new RuntimeException(
            'O teste de rollback falhou: nenhuma exceção foi provocada.'
        );
    }

    // Confirma que o livro temporário não permaneceu no banco
    if ($idRollback !== null) {

        $verificacao = $livros->buscar($idRollback);

        if ($verificacao === null) {
            echo "SUCESSO: o livro temporário não permaneceu no banco.\n\n";
        } else {
            throw new RuntimeException(
                'Falha no rollback: o livro ainda existe no banco.'
            );
        }
    }


    // =========================================================
    // EVIDÊNCIA 7 - EXCLUSÃO E CHAVES ESTRANGEIRAS
    // =========================================================

    echo "============================================\n";
    echo "EVIDÊNCIA 7 - EXCLUSÃO E INTEGRIDADE\n";
    echo "============================================\n";

    // Primeiro, tenta excluir um autor que possui vínculo
    $autoresVinculados = $livros->autoresDoLivro($livro->id());

    if (count($autoresVinculados) > 0) {

        $autorVinculado = $autoresVinculados[0];

        echo "Tentando excluir o autor vinculado:\n";
        echo "Autor: {$autorVinculado->nome()}\n";
        echo "ID: {$autorVinculado->id()}\n";

        try {

            $autores->excluir($autorVinculado->id());

            throw new RuntimeException(
                'A exclusão do autor vinculado não deveria ser permitida.'
            );

        } catch (PDOException $e) {

            echo "SUCESSO: exclusão bloqueada pelo banco de dados.\n";
            echo "Motivo: existe um vínculo na tabela livros_autores.\n";
            echo "A chave estrangeira protege a integridade dos dados.\n\n";
        }

    } else {

        echo "Não foram encontrados autores vinculados.\n\n";
    }


    // Agora cria e exclui um livro sem vínculos
    echo "Testando exclusão de um livro sem vínculos...\n";

    $livroExclusao = new Livro(
        'Livro temporário para exclusão ' . uniqid(),
        null,
        2026
    );

    $livros->salvar($livroExclusao);

    $idExclusao = $livroExclusao->id();

    echo "Livro temporário criado. ID: {$idExclusao}\n";

    $livros->excluir($idExclusao);

    $verificacaoExclusao = $livros->buscar($idExclusao);

    if ($verificacaoExclusao === null) {
        echo "SUCESSO: livro excluído corretamente.\n\n";
    } else {
        throw new RuntimeException(
            'Falha: o livro temporário ainda existe no banco.'
        );
    }


    // =========================================================
    // RESULTADO FINAL
    // =========================================================

    echo "============================================\n";
    echo "       TODOS OS TESTES CONCLUÍDOS!\n";
    echo "============================================\n";

} catch (Throwable $e) {

    // Evita deixar uma transação aberta em caso de falha
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "\n============================================\n";
    echo "ERRO DURANTE A EXECUÇÃO\n";
    echo "============================================\n";

    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
}