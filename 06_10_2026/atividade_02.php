<?php

class Produto {
    private float $preco;

    public function setPreco(float $preco): void {
        if ($preco <= 0) {
            throw new InvalidArgumentException("Preço deve ser maior que zero.");
        }
        $this->preco = $preco;
    }

    public function getPreco(): float {
        return $this->preco;
    }
}