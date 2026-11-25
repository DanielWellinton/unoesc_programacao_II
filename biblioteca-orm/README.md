# BibliotecaORM

Projeto acadêmico desenvolvido para a disciplina de **Programação II**, com o objetivo de implementar uma pequena biblioteca ORM (*Object-Relational Mapping*) em PHP, utilizando PDO e MySQL, sem depender de bibliotecas ORM de terceiros.

O projeto demonstra os conceitos de orientação a objetos, encapsulamento, abstração, herança, polimorfismo, persistência de dados, relacionamentos entre entidades e controle de transações.

## 1. Tecnologias utilizadas

- **PHP 8.2**
- **MySQL 8**
- **PDO** para comunicação com o banco de dados
- **Docker e Docker Compose** para execução do ambiente
- **Git** para controle de versão

## 2. Estrutura do projeto

```text
biblioteca-orm/
├── autoload.php
├── sql/
│   ├── schema.sql
│   └── seed.sql
├── src/
│   ├── Domain/
│   │   ├── Livro.php
│   │   └── Autor.php
│   └── Infrastructure/
│       ├── Conexao.php
│       ├── RepositoryInterface.php
│       ├── AbstractRepository.php
│       ├── LivroRepository.php
│       └── AutorRepository.php
└── tests/
    └── smoke.php
```

### Descrição dos diretórios

| Diretório/arquivo | Responsabilidade |
|---|---|
| `src/Domain/` | Contém as entidades do domínio: Livro e Autor. |
| `src/Infrastructure/` | Contém a conexão com o banco e a implementação dos repositórios. |
| `sql/` | Contém os scripts de criação e alimentação do banco de dados. |
| `tests/` | Contém o script de testes e demonstrações do funcionamento do ORM. |
| `autoload.php` | Realiza o carregamento automático das classes. |

## 3. Modelo de dados

O banco de dados utiliza três tabelas principais:

- **livros:** armazena os dados dos livros.
- **autores:** armazena os dados dos autores.
- **livros_autores:** tabela intermediária responsável pelo relacionamento muitos-para-muitos entre livros e autores.

O relacionamento permite que um livro tenha vários autores e que um autor esteja associado a vários livros.

As chaves primárias são geradas automaticamente pelo MySQL. A tabela intermediária possui uma chave primária composta por `livro_id` e `autor_id`, evitando associações duplicadas.

Também são utilizadas chaves estrangeiras para garantir a integridade referencial.

## 4. Como executar o projeto

### 4.1. Pré-requisitos

Antes de iniciar, é necessário ter instalado:

- Docker
- Docker Compose

O projeto deve estar organizado conforme a estrutura apresentada anteriormente.

### 4.2. Iniciar os containers

Na raiz do projeto, execute:

```bash
docker-compose up -d
```

Esse comando inicia os serviços definidos no arquivo `docker-compose.yml` em segundo plano.

Para verificar se os containers estão em execução:

```bash
docker-compose ps
```

### 4.3. Criar a estrutura do banco de dados

Execute o script `schema.sql`, responsável pela criação do banco de dados e das tabelas:

```bash
docker-compose exec -T db mysql -u biblioteca -p biblioteca_orm < biblioteca-orm/sql/schema.sql
```

**Observação:** o comando considera que o serviço do MySQL no `docker-compose.yml` se chama `db`, e que o usuário e o banco possuem os nomes `biblioteca` e `biblioteca_orm`. Caso sua configuração utilize outros nomes, ajuste o comando conforme as variáveis definidas no Docker Compose.

O script deve ser executado antes do script de dados iniciais.

### 4.4. Inserir dados iniciais

Após criar as tabelas, execute:

```bash
docker-compose exec -T db mysql -u biblioteca -p biblioteca_orm < biblioteca-orm/sql/seed.sql
```

O script `seed.sql` insere registros iniciais de livros e autores, além de estabelecer algumas associações entre eles.

**Importante:** o MySQL solicitará a senha do usuário configurado no banco.

### 4.5. Executar os testes

Com os containers em execução e o banco de dados configurado, execute:

```bash
docker-compose exec app php biblioteca-orm/tests/smoke.php
```

Esse comando executa o script de demonstração do ORM dentro do container PHP.

O script realiza operações de persistência e verifica os principais requisitos da implementação.

## 5. Funcionalidades implementadas

### Entidades

As classes `Livro` e `Autor` representam os objetos do domínio.

As entidades utilizam:

- Propriedades privadas.
- Construtores.
- Métodos de acesso.
- Validação de dados.
- Identificadores atribuídos após a persistência no banco.

### Repositórios

A interface `RepositoryInterface` estabelece um contrato comum para os repositórios:

```php
buscar(int $id)
listar()
salvar(object $entidade)
excluir(int $id)
```

A classe abstrata `AbstractRepository` implementa comportamentos compartilhados, evitando duplicação de código.

As classes `LivroRepository` e `AutorRepository` herdam essa implementação e fornecem os mapeamentos específicos de cada entidade.

### Persistência e hidratação

O ORM permite salvar objetos no banco de dados e reconstruir objetos PHP a partir dos registros recuperados.

A hidratação transforma os dados retornados pelo MySQL em instâncias reais das classes `Livro` e `Autor`, preservando seus tipos e identificadores.

### Relacionamento muitos-para-muitos

O `LivroRepository` implementa operações para associar autores a livros e recuperar a coleção de autores de determinado livro.

### Segurança e integridade

A implementação utiliza:

- Consultas preparadas com PDO.
- Parâmetros para valores externos.
- Identificadores SQL definidos internamente pelos repositórios.
- Chaves estrangeiras no banco de dados.
- Transações para operações que envolvem múltiplas alterações.

## 6. Evidências de execução

O arquivo `tests/smoke.php` demonstra os seguintes cenários:

1. Cadastro de um livro e dois autores, utilizando identificadores gerados pelo MySQL.
2. Busca de um livro pelo ID e reconstrução de suas propriedades.
3. Atualização do título e nova consulta para verificar a alteração.
4. Associação de dois autores a um livro e recuperação da coleção.
5. Demonstração de polimorfismo, utilizando o mesmo contrato para `LivroRepository` e `AutorRepository`.
6. Simulação de um erro durante uma transação e demonstração do rollback.
7. Exclusão controlada e demonstração das restrições de chave estrangeira.

## 7. Decisões de implementação

A implementação foi desenvolvida sem utilizar frameworks ou bibliotecas ORM externas, com o propósito de demonstrar o funcionamento dos principais mecanismos de um ORM.

A separação entre domínio e infraestrutura permite manter as entidades independentes dos detalhes de persistência.

A utilização de uma interface e de uma classe abstrata permite compartilhar comportamentos entre os repositórios, mantendo suas responsabilidades específicas.

O PDO foi escolhido para realizar a comunicação com o MySQL, permitindo o uso de consultas preparadas e transações.

## 8. Considerações finais

O projeto demonstra a implementação de uma estrutura ORM simplificada em PHP, contemplando mapeamento objeto-relacional, persistência, hidratação, relacionamentos, abstração, herança, polimorfismo e transações.

A proposta permite compreender como bibliotecas ORM organizam a comunicação entre objetos de domínio e bancos de dados relacionais.