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
        $stmt = $this->pdo->prepare(
            'INSERT INTO livro
            (titulo, isbn, ano_publicacao, preco, quantidade, id_autor)
            VALUES (:titulo, :isbn, :ano_publicacao, :preco, :quantidade, :id_autor)'
        );
        $stmt->bindParam(':titulo', $titulo,PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $isbn,PDO::PARAM_STR);
        $stmt->bindParam(':ano_publicacao', $anoPublicacao,PDO::PARAM_INT);
        $stmt->bindParam(':preco', $preco,PDO::PARAM_STR);
        $stmt->bindParam(':id_autor', $idAutor,PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade,PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Tarefa criada com sucesso!'];
        } else {
            return ['status' => false, 'message' => 'Erro ao criar tarefa.'];
        }
    }
}
