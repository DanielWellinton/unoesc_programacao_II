<?php

class Aluno {
    private string $nome;
    private float $nota;

    public function setNota(float $nota): void {
        if ($nota < 0 || $nota > 10) {
            throw new InvalidArgumentException("A nota deve estar entre 0 e 10.");
        }
        $this->nota = $nota;
    }

    public function getNota(): float {
        return $this->nota;
    }
}