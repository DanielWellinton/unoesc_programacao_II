<?php

class Cliente {
    private string $nome;
    private string $cpf;

    public function setNome(string $nome): void {
        if (empty(trim($nome))) {
            throw new InvalidArgumentException("O nome não pode ser vazio.");
        }
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setCpf(string $cpf): void {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpfLimpo) !== 11) {
            throw new InvalidArgumentException("CPF inválido.");
        }
        $this->cpf = $cpfLimpo;
    }

    public function getCpf(): string {
        return $this->cpf;
    }
}