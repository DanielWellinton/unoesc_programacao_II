<?php

namespace Biblioteca\Infrastructure;

interface RepositoryInterface
{
    public function buscar(int $id): ?object;

    public function listar(): array;

    public function salvar(object $entidade): void;

    public function excluir(int $id): void;
}