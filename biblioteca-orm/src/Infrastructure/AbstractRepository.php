<?php

namespace Biblioteca\Infrastructure;

abstract class AbstractRepository implements RepositoryInterface
{
    public function __construct(protected \PDO $pdo)
    {
    }

    abstract protected function tabela(): string;

    abstract protected function colunas(): array;

    abstract protected function hidratar(array $linha): object;

    abstract protected function extrair(object $entidade): array;

    abstract protected function identidade(object $entidade): ?int;

    abstract protected function definirIdentidade(
        object $entidade,
        int $id
    ): void;

    public function buscar(int $id): ?object
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM ' . $this->tabela() . ' WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);

        $linha = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $linha === false
            ? null
            : $this->hidratar($linha);
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM ' . $this->tabela() . ' ORDER BY id'
        );

        return array_map(
            fn(array $linha) => $this->hidratar($linha),
            $stmt->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    public function salvar(object $entidade): void
    {
        $dados = $this->extrair($entidade);

        $colunas = $this->colunas();

        if (array_keys($dados) !== $colunas) {
            throw new \LogicException(
                'Mapeamento inconsistente'
            );
        }

        $id = $this->identidade($entidade);

        if ($id === null) {

            $nomes = implode(', ', $colunas);

            $marcadores = implode(
                ', ',
                array_map(fn($c) => ':' . $c, $colunas)
            );

            $stmt = $this->pdo->prepare(
                "INSERT INTO {$this->tabela()} ($nomes)
                VALUES ($marcadores)"
            );

            $stmt->execute($dados);

            $this->definirIdentidade(
                $entidade,
                (int) $this->pdo->lastInsertId()
            );

        } else {

            $atribuicoes = implode(
                ', ',
                array_map(fn($c) => "$c = :$c", $colunas)
            );

            $stmt = $this->pdo->prepare(
                "UPDATE {$this->tabela()}
                SET $atribuicoes
                WHERE id = :id"
            );

            $stmt->execute($dados + ['id' => $id]);
        }
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM ' . $this->tabela() . ' WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
    }
}