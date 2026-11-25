<?php

namespace Biblioteca\Infrastructure;

use Biblioteca\Domain\Autor;

final class AutorRepository extends AbstractRepository
{
    protected function tabela(): string
    {
        return 'autores';
    }

    protected function colunas(): array
    {
        return [
            'nome',
            'nacionalidade'
        ];
    }

    protected function hidratar(array $linha): Autor
    {
        $autor = new Autor(
            $linha['nome'],
            $linha['nacionalidade']
        );

        $autor->atribuirId((int) $linha['id']);

        return $autor;
    }

    protected function extrair(object $entidade): array
    {
        if (!$entidade instanceof Autor) {
            throw new \InvalidArgumentException(
                'Esperado Autor'
            );
        }

        return [
            'nome' => $entidade->nome(),
            'nacionalidade' => $entidade->nacionalidade()
        ];
    }

    protected function identidade(object $entidade): ?int
    {
        if (!$entidade instanceof Autor) {
            throw new \InvalidArgumentException(
                'Esperado Autor'
            );
        }

        return $entidade->id();
    }

    protected function definirIdentidade(
        object $entidade,
        int $id
    ): void {
        if (!$entidade instanceof Autor) {
            throw new \InvalidArgumentException(
                'Esperado Autor'
            );
        }

        $entidade->atribuirId($id);
    }
}