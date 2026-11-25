<?php

spl_autoload_register(function (string $classe) {

    $prefixo = 'Biblioteca\\';

    if (!str_starts_with($classe, $prefixo)) {
        return;
    }

    $caminhoRelativo = substr(
        $classe,
        strlen($prefixo)
    );

    $arquivo = __DIR__ . '/src/' .
        str_replace('\\', '/', $caminhoRelativo) .
        '.php';

    if (file_exists($arquivo)) {
        require_once $arquivo;
    }
});