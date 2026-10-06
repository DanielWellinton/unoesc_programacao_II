<?php

class CarrinhoDeCompras {
    private float $total = 0.0;

    public function adicionarValor(float $valor): void {
        if ($valor < 0) {
            throw new InvalidArgumentException("O valor a ser adicionado não pode ser negativo.");
        }
        $this->total += $valor;
    }

    public function getTotal(): float {
        return $this->total;
    }
}