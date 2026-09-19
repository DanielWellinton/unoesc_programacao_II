<?php

class Item {
    private string $descricao;
    private int $quantidade;
    private float $valor;

    public function __construct(string $descricao, int $quantidade, float $valor)
    {
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function getSubtotal(): float
    {
        return $this->quantidade * $this->valor;
    }

    public function __toString(): string
    {
        $valorFormatado = number_format($this->valor, 2, ',', '.');
        $subtotalFormatado = number_format($this->getSubtotal(), 2, ',', '.');

        return "<b>Item:</b> {$this->descricao}<br>" .
               "<b>Qtd:</b> {$this->quantidade}<br>" .
               "<b>Valor Un.:</b> R$ {$valorFormatado}<br>" .
               "<b>Subtotal:</b> R$ {$subtotalFormatado}";
    }
}

class Carrinho {
    /**
     * @var Item[]
     */
    private array $items = [];

    public function adicionarItem(Item $item): array
    {
        $this->items[] = $item;
        return $this->items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function calcularTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }

    public function getTotalFormatado(): string
    {
        return 'R$ ' . number_format($this->calcularTotal(), 2, ',', '.');
    }
}