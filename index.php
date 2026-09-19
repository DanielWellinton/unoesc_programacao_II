<?php
date_default_timezone_set('America/Sao_Paulo');

require_once '15_09_2026/atividade_01.php';
require_once '15_09_2026/atividade_02.php';
require_once '15_09_2026/atividade_03.php';
require_once '15_09_2026/atividade_04.php';
require_once '15_09_2026/atividade_05.php';
require_once '15_09_2026/atividade_06.php';
require_once '15_09_2026/atividade_07.php';
require_once '15_09_2026/atividade_08.php';
require_once '15_09_2026/atividade_09.php';
require_once '15_09_2026/atividade_10.php';

$carro1 = new Carro("Civic", "Honda", 2022);
$carro2 = new Carro("Fusion", "Ford", 2012);

$aluno1 = new Aluno("Daniel Bortolossi", 8.5);
$aluno2 = new Aluno("Wellinton Bortolossi", 6.5);

$contaBancaria = new ContaBancaria("Daniel Bortolossi", 7000);

$contato1 = new Contato("Daniel", "(01) 2.3456-7890", "contato1@teste.com");
$contato2 = new Contato("Wellinton", "(09) 8.7654-3210", "contato2@teste.com");
$agendaContato = new AgendaContato();
$agendaContato->adicionarContato($contato1);
$agendaContato->adicionarContato($contato2);

$retangulo = new Retangulo(5, 3);

$funcionario = new Funcionario("Daniel Bortolossi", 4500,00);

$item1 = new Item("Carne moída", 0.5, 34.9);
$item2 = new Item("Picanha", 1, 109.99);
$carrinho = new Carrinho();
$carrinho->adicionarItem($item1);
$carrinho->adicionarItem($item2);

$livros = [
    new Livro("Dom Casmurro", "Machado de Assis", 1899),
    new Livro("O Alquimista", "Paulo Coelho", 1988),
    new Livro("Clean Architecture", "Robert C. Martin", 2017),
    new Livro("Entendendo Algoritmos", "Aditya Y. Bhargava", 2017),
    new Livro("Domain-Driven Design", "Eric Evans", 2003),
    new Livro("O Hobbit", "J.R.R. Tolkien", 1937),
    new Livro("Refatoração", "Martin Fowler", 2018)
];
$livrosRecentes = array_filter($livros, function(Livro $livro) {
    return $livro->getAno() > 2015;
});

require_once 'views/layout.phtml';