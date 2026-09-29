<?php

class Produto {
    public $nome;
    public $preco;
}

$produto = new Produto();
$produto->nome = "Notebook";
$produto->preco = 4500.00;

echo "Produto: {$produto->nome} | Preço: R$ {$produto->preco}\n";