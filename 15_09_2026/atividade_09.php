<?php

class Livro {
    private string $titulo;
    private string $autor;
    private int $ano;

    public function __construct(string $titulo, string $autor, int $ano)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ano = $ano;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function __toString(): string
    {
        return "<b>Título:</b> {$this->titulo}<br>" .
               "<b>Autor:</b> {$this->autor}<br>" .
               "<b>Ano:</b> {$this->ano}";
    }
}