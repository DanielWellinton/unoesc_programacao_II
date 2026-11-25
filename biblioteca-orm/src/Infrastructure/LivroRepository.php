<?php

namespace Biblioteca\Infrastructure;

use Biblioteca\Domain\Livro;
use Biblioteca\Domain\Autor;

final class LivroRepository extends AbstractRepository
{
    protected function tabela(): string
    {
        return 'livros';
    }

    protected function colunas(): array
    {
        return [
            'titulo',
            'isbn',
            'ano_publicacao'
        ];
    }

    protected function hidratar(array $linha): Livro
    {
        $livro = new Livro(
            $linha['titulo'],
            $linha['isbn'],
            $linha['ano_publicacao'] === null
                ? null
                : (int) $linha['ano_publicacao']
        );

        $livro->atribuirId((int) $linha['id']);

        return $livro;
    }

    protected function extrair(object $entidade): array
    {
        if (!$entidade instanceof Livro) {
            throw new \InvalidArgumentException(
                'Esperado Livro'
            );
        }

        return [
            'titulo' => $entidade->titulo(),
            'isbn' => $entidade->isbn(),
            'ano_publicacao' => $entidade->anoPublicacao()
        ];
    }

    protected function identidade(object $entidade): ?int
    {
        if (!$entidade instanceof Livro) {
            throw new \InvalidArgumentException(
                'Esperado Livro'
            );
        }

        return $entidade->id();
    }

    protected function definirIdentidade(
        object $entidade,
        int $id
    ): void {
        if (!$entidade instanceof Livro) {
            throw new \InvalidArgumentException(
                'Esperado Livro'
            );
        }

        $entidade->atribuirId($id);
    }

    public function autoresDoLivro(int $livroId): array
    {
        $sql = '
            SELECT a.*
            FROM autores a
            INNER JOIN livros_autores la
                ON la.autor_id = a.id
            WHERE la.livro_id = :id
            ORDER BY a.nome
        ';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $livroId]);

        return array_map(
            function (array $linha) {

                $autor = new Autor(
                    $linha['nome'],
                    $linha['nacionalidade']
                );

                $autor->atribuirId((int) $linha['id']);

                return $autor;
            },
            $stmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function associarAutor(
        int $livroId,
        int $autorId
    ): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO livros_autores
            (livro_id, autor_id)
            VALUES (:livro, :autor)'
        );

        $stmt->execute([
            'livro' => $livroId,
            'autor' => $autorId
        ]);
    }
}