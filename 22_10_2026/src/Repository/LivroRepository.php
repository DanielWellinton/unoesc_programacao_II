<?php

class LivroRepository
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, titulo, preco FROM livro WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $linha = $stmt->fetch();
        return $linha === false ? null : $linha;
    }

    public function create(string $titulo, string $isbn, int $anoPublicacao, float $preco, int $idAutor, int $quantidade = 0)
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO livro
                (titulo, isbn, ano_publicacao, preco, quantidade, id_autor)
                VALUES (:titulo, :isbn, :ano_publicacao, :preco, :quantidade, :id_autor)'
            );

            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
            $stmt->bindParam(':ano_publicacao', $anoPublicacao, PDO::PARAM_INT);
            $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':id_autor', $idAutor, PDO::PARAM_INT);

            $stmt->execute();

            return true;

        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new \Exception("Erro: O ISBN '{$isbn}' já está cadastrado ou o ID do autor é inválido.");
            }
            throw new \Exception("Erro ao cadastrar livro: " . $e->getMessage());
        }
    }
}
