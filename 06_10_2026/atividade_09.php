<?php

class Config {
    protected array $parametros = [];

    protected function setParametro(string $chave, mixed $valor): void {
        $this->parametros[$chave] = $valor;
    }

    public function getParametro(string $chave): mixed {
        return $this->parametros[$chave] ?? null;
    }
}

class GerenciadorConfig extends Config {
    public function atualizarConfiguracao(string $chave, mixed $valor): void {
        $this->setParametro($chave, $valor);
    }

    public function exibirParametros(): array {
        return $this->parametros;
    }
}