<?php

class Produto {
    public $nome;
    private $preco;

    public function setPreco($preco) {
        if ($preco >= 0) {
            $this->preco = $preco;
        }
    }

    public function getPreco() {
        return $this->preco;
    }
}