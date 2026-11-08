-- ============================================================================
-- TRABALHO PRÁTICO: LINGUAGEM SQL E COMANDOS DML (PROJETO BIBLIOTECA)
-- Ambiente: MySQL 8.x com InnoDB
-- ============================================================================

USE biblioteca;

-- ----------------------------------------------------------------------------
-- 1. INSERÇÃO INDIVIDUAL
-- Objetivo: Cadastrar um novo autor e demonstrar o identificador atribuído.
-- ----------------------------------------------------------------------------
INSERT INTO autor (nome, nacionalidade) 
VALUES ('Machado de Assis', 'Brasileira');

-- Verificação do identificador gerado automaticamente por AUTO_INCREMENT:
SELECT LAST_INSERT_ID() AS autor_id_gerado;
SELECT id, nome, nacionalidade FROM autor WHERE id = LAST_INSERT_ID();


-- ----------------------------------------------------------------------------
-- 2. INSERÇÃO MÚLTIPLA
-- Objetivo: Cadastrar três livros com ISBNs distintos e referências válidas
-- ----------------------------------------------------------------------------
INSERT INTO livro (titulo, isbn, ano_publicacao, preco, quantidade, id_autor) VALUES
('Dom Casmurro', '9788535914841', 1899, 39.90, 5, 1),
('Memórias Póstumas de Brás Cubas', '9788535914842', 1881, 45.00, 8, 1),
('Quincas Borba', '9788535914843', 1891, 42.50, 4, 1);


-- ----------------------------------------------------------------------------
-- 3. INSERÇÃO DERIVADA
-- Objetivo: Criar tabela auxiliar de relatórios e popular com INSERT INTO ... SELECT
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS livro_relatorio (
    id_livro INT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    valor_estoque DECIMAL(14,2) NOT NULL
) ENGINE=InnoDB;

-- Populando a tabela auxiliar com dados calculados da base principal:
INSERT INTO livro_relatorio (id_livro, titulo, valor_estoque)
SELECT id, titulo, (preco * quantidade)
FROM livro 
WHERE quantidade > 0;

-- Conferência da tabela derivada:
SELECT * FROM livro_relatorio;


-- ----------------------------------------------------------------------------
-- 4. ATUALIZAÇÃO PONTUAL
-- Objetivo: Reajustar o preço de um livro identificado pela chave primária
-- ----------------------------------------------------------------------------
-- Pré-condição: Consultar estado atual
SELECT id, titulo, preco FROM livro WHERE id = 1;

-- Execução da atualização pontual com WHERE restrito à chave primária:
UPDATE livro 
SET preco = 49.90 
WHERE id = 1;

-- Pós-confirmação: Conferir se o valor foi alterado corretamente
SELECT id, titulo, preco FROM livro WHERE id = 1;


-- ----------------------------------------------------------------------------
-- 5. ATUALIZAÇÃO CONDICIONAL
-- Objetivo: Aplicar reajuste a um subconjunto selecionado e validar efeitos
-- ----------------------------------------------------------------------------
-- Aplicar reajuste de 10% em livros com preço inferior a 45.00 e quantidade disponível:
UPDATE livro 
SET preco = ROUND(preco * 1.10, 2) 
WHERE preco < 45.00 AND quantidade > 0;

-- Verificação imediata do número de linhas afetadas pela instrução anterior:
SELECT ROW_COUNT() AS linhas_afetadas;


-- ----------------------------------------------------------------------------
-- 6. EXCLUSÃO CONTROLADA
-- Objetivo: Excluir registro de teste após verificar dependências
-- ----------------------------------------------------------------------------
-- Inserir temporariamente um livro de teste para exclusão:
INSERT INTO livro (titulo, isbn, ano_publicacao, preco, quantidade, id_autor) 
VALUES ('Livro Temporário', '9789999999999', 2024, 10.00, 1, 1);

-- Identificar a chave primária gerada para exclusão segura:
SELECT id, titulo FROM livro WHERE isbn = '9789999999999';

-- Exclusão condicionada por chave primária (após conferir dependências):
DELETE FROM livro WHERE isbn = '9789999999999';


-- ----------------------------------------------------------------------------
-- 7. CONSULTA RELACIONAL
-- Objetivo: Listar livros e autores com LEFT JOIN e ordenação explícita
-- ----------------------------------------------------------------------------
SELECT 
    l.id, 
    l.titulo, 
    a.nome AS autor, 
    l.preco, 
    l.quantidade
FROM livro AS l
LEFT JOIN autor AS a ON a.id = l.id_autor
ORDER BY l.titulo ASC;


-- ----------------------------------------------------------------------------
-- 8. RELATÓRIO
-- Objetivo: Calcular títulos, exemplares e valor de estoque por autor
-- ----------------------------------------------------------------------------
SELECT 
    a.id,
    a.nome AS autor,
    COUNT(l.id) AS titulos,
    COALESCE(SUM(l.quantidade), 0) AS exemplares,
    COALESCE(SUM(l.preco * l.quantidade), 0) AS valor_estoque
FROM autor AS a
LEFT JOIN livro AS l ON l.id_autor = a.id
GROUP BY a.id, a.nome
ORDER BY valor_estoque DESC;


-- ----------------------------------------------------------------------------
-- 9. TRANSAÇÃO
-- Objetivo: Demonstrar COMMIT e ROLLBACK com alteração controlada de estoque
-- ----------------------------------------------------------------------------
START TRANSACTION;

-- Tentativa de baixa de estoque controlada:
UPDATE livro 
SET quantidade = quantidade - 1 
WHERE id = 1 AND quantidade > 0;

-- Verificação das linhas afetadas:
SELECT ROW_COUNT() AS linhas_afetadas;

-- Se linhas_afetadas == 1, confirmamos a operação com COMMIT. 
-- Caso contrário, revertemos com ROLLBACK.
COMMIT; 
-- (ou ROLLBACK; em caso de falha lógica)