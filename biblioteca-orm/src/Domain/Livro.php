<?php

namespace Biblioteca\Domain;

final class Livro
{
    private ?int $id = null;
    private string $titulo;
    private ?string $isbn;
    private ?int $anoPublicacao;

    /** @var Autor[] */
    private array $autores = [];

    public function __construct(
        string $titulo,
        ?string $isbn = null,
        ?int $ano = null
    ) {
        $this->alterarTitulo($titulo);

        $this->isbn = $isbn;
        $this->anoPublicacao = $ano;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function atribuirId(int $id): void
    {
        if (
            $id <= 0 ||
            ($this->id !== null && $this->id !== $id)
        ) {
            throw new \LogicException('Identidade inválida');
        }

        $this->id = $id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function isbn(): ?string
    {
        return $this->isbn;
    }

    public function anoPublicacao(): ?int
    {
        return $this->anoPublicacao;
    }

    public function alterarTitulo(string $titulo): void
    {
        if (trim($titulo) === '') {
            throw new \InvalidArgumentException(
                'Título obrigatório'
            );
        }

        $this->titulo = trim($titulo);
    }

    public function adicionarAutor(Autor $autor): void
    {
        foreach ($this->autores as $existente) {

            if (
                $existente === $autor ||
                (
                    $autor->id() !== null &&
                    $existente->id() === $autor->id()
                )
            ) {
                return;
            }
        }

        $this->autores[] = $autor;
    }

    public function autores(): array
    {
        return $this->autores;
    }
}