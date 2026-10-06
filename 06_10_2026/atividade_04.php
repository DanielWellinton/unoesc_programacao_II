<?php

class Usuario {
    private string $senha;

    public function __construct(string $senhaPura) {
        $this->setSenha($senhaPura);
    }

    public function setSenha(string $senha): void {
        if (strlen($senha) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function verificarSenha(string $senhaDigitada): bool {
        return password_verify($senhaDigitada, $this->senha);
    }
}