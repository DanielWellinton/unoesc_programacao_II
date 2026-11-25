USE biblioteca_orm;

START TRANSACTION;

-- ==========================================
-- 1. CADASTRO DE AUTORES
-- ==========================================

INSERT INTO autores (nome, nacionalidade)
SELECT 'Machado de Assis', 'Brasileira'
WHERE NOT EXISTS (
    SELECT 1 FROM autores
    WHERE nome = 'Machado de Assis'
);

INSERT INTO autores (nome, nacionalidade)
SELECT 'José de Alencar', 'Brasileira'
WHERE NOT EXISTS (
    SELECT 1 FROM autores
    WHERE nome = 'José de Alencar'
);

INSERT INTO autores (nome, nacionalidade)
SELECT 'Clarice Lispector', 'Ucraniana'
WHERE NOT EXISTS (
    SELECT 1 FROM autores
    WHERE nome = 'Clarice Lispector'
);

INSERT INTO autores (nome, nacionalidade)
SELECT 'George Orwell', 'Britânica'
WHERE NOT EXISTS (
    SELECT 1 FROM autores
    WHERE nome = 'George Orwell'
);

INSERT INTO autores (nome, nacionalidade)
SELECT 'J. R. R. Tolkien', 'Britânica'
WHERE NOT EXISTS (
    SELECT 1 FROM autores
    WHERE nome = 'J. R. R. Tolkien'
);


-- ==========================================
-- 2. CADASTRO DE LIVROS
-- ==========================================

INSERT INTO livros (titulo, isbn, ano_publicacao)
SELECT 'Dom Casmurro', '9788535910663', 1899
WHERE NOT EXISTS (
    SELECT 1 FROM livros
    WHERE isbn = '9788535910663'
);

INSERT INTO livros (titulo, isbn, ano_publicacao)
SELECT 'O Guarani', '9788525409915', 1857
WHERE NOT EXISTS (
    SELECT 1 FROM livros
    WHERE isbn = '9788525409915'
);

INSERT INTO livros (titulo, isbn, ano_publicacao)
SELECT 'A Hora da Estrela', '9788520925688', 1977
WHERE NOT EXISTS (
    SELECT 1 FROM livros
    WHERE isbn = '9788520925688'
);

INSERT INTO livros (titulo, isbn, ano_publicacao)
SELECT '1984', '9788535914849', 1949
WHERE NOT EXISTS (
    SELECT 1 FROM livros
    WHERE isbn = '9788535914849'
);

INSERT INTO livros (titulo, isbn, ano_publicacao)
SELECT 'O Senhor dos Anéis', '9788595084759', 1954
WHERE NOT EXISTS (
    SELECT 1 FROM livros
    WHERE isbn = '9788595084759'
);


-- ==========================================
-- 3. RELACIONAMENTO ENTRE LIVROS E AUTORES
-- ==========================================

-- Dom Casmurro -> Machado de Assis

INSERT IGNORE INTO livros_autores (livro_id, autor_id)
SELECT l.id, a.id
FROM livros l
INNER JOIN autores a
    ON a.nome = 'Machado de Assis'
WHERE l.isbn = '9788535910663';


-- O Guarani -> José de Alencar

INSERT IGNORE INTO livros_autores (livro_id, autor_id)
SELECT l.id, a.id
FROM livros l
INNER JOIN autores a
    ON a.nome = 'José de Alencar'
WHERE l.isbn = '9788525409915';


-- A Hora da Estrela -> Clarice Lispector

INSERT IGNORE INTO livros_autores (livro_id, autor_id)
SELECT l.id, a.id
FROM livros l
INNER JOIN autores a
    ON a.nome = 'Clarice Lispector'
WHERE l.isbn = '9788520925688';


-- 1984 -> George Orwell

INSERT IGNORE INTO livros_autores (livro_id, autor_id)
SELECT l.id, a.id
FROM livros l
INNER JOIN autores a
    ON a.nome = 'George Orwell'
WHERE l.isbn = '9788535914849';


-- O Senhor dos Anéis -> J. R. R. Tolkien

INSERT IGNORE INTO livros_autores (livro_id, autor_id)
SELECT l.id, a.id
FROM livros l
INNER JOIN autores a
    ON a.nome = 'J. R. R. Tolkien'
WHERE l.isbn = '9788595084759';


-- ==========================================
-- 4. FINALIZAÇÃO
-- ==========================================

COMMIT;

-- ==========================================
-- 5. CONSULTA PARA CONFERIR OS DADOS
-- ==========================================

SELECT
    l.id,
    l.titulo,
    l.isbn,
    l.ano_publicacao,
    a.nome AS autor
FROM livros l
INNER JOIN livros_autores la
    ON la.livro_id = l.id
INNER JOIN autores a
    ON a.id = la.autor_id
ORDER BY l.id;