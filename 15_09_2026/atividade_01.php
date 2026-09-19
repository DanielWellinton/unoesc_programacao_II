<?php

class Carro
{
    private string $modelo;
    private string $marca;
    private int $ano;

    public function __construct(string $modelo, string $marca, int $ano)
    {
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->ano = $ano;
    }

    public function exibirInformacoes(): string
    {
        return "<strong>Modelo:</strong> {$this->modelo}<br>
                <strong>Marca:</strong> {$this->marca}<br>
                <strong>Ano:</strong> {$this->ano}";
    }
}
