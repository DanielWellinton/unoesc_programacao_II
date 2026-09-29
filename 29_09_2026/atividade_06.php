<?php

class Config {
    protected $parametros = [];

    public function setParametro($chave, $valor) {
        $this->parametros[$chave] = $valor;
    }
}

class SubConfig extends Config {
    public function getParametro($chave) {
        return $this->parametros[$chave] ?? null;
    }
}