<?php

class Aluno
{
    private string $nome;
    private float $media;

    public function __construct(string $nome, float $media)
    {
        $this->nome = $nome;
        $this->media = $media;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function verificarAprovacao(): bool
    {
        if ($this->media >= 7.0) {
            return true;
        }
        return false;
    }
}
