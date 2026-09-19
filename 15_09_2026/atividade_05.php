<?php

class Contato {
    private string $nome;
    private string $telefone;
    private string $email;

    public function __construct(string $nome, string $telefone, string $email)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return "<b>Nome: </b> $this->nome <br><b>Telefone: </b>$this->telefone<br><b>Email: </b>$this->email";
    }
}

class AgendaContato {
    /** @var Contato[] */
    private array $listaContatos = [];

    public function adicionarContato(Contato $contato): void
    {
        $this->listaContatos[] = $contato;
    }

    public function buscarContatoPorNome(string $nome): ?Contato
    {
        foreach ($this->listaContatos as $contato) {
            if (strcasecmp($contato->getNome(), $nome) === 0) {
                return $contato;
            }
        }
        return null;
    }

    public function removerContato(string $nome): bool
    {
        foreach ($this->listaContatos as $index => $contato) {
            if (strcasecmp($contato->getNome(), $nome) === 0) {
                unset($this->listaContatos[$index]);
                $this->listaContatos = array_values($this->listaContatos);
                return true;
            }
        }
        return false;
    }

    public function getListaContatos(): array
    {
        return $this->listaContatos;
    }
}