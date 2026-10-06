<?php

class Pedido {
    private array $itens = [];

    public function adicionarItem(string $produto, float $preco): void {
        if ($preco <= 0) {
            throw new InvalidArgumentException("O preço do item deve ser positivo.");
        }
        $this->itens[] = [
            'produto' => $produto,
            'preco' => $preco
        ];
    }

    public function listarItens(): array {
        return $this->itens;
    }
}