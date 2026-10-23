## Por que o PDO e o Repository NÃO são um ORM?

A utilização de classes de repositório (`Repository`) em conjunto com o `PDO` costuma gerar dúvidas, parecendo à primeira vista um **ORM** (Object-Relational Mapping), como o Doctrine ou o Eloquent. No entanto, existem diferenças fundamentais entre estas abordagens:

1. **Escrita manual de consultas SQL:**
   O **PDO** é apenas uma camada de abstração para conexão e execução de comandos na base de dados. Nele, as consultas SQL (`SELECT`, `INSERT`, `UPDATE`, `DELETE`) são escritas e mantidas de forma nativa e manual. Um ORM, por sua vez, gera essas instruções de forma totalmente automatizada com base nas classes e metadados.

2. **Hidratação e Mapeamento Manual:**
   No padrão *Repository* que implementámos, a conversão dos dados relacionais em objetos (`hidratação`) é feita de forma imperativa — percorremos o array associativo retornado pelo PDO e instanciamos manualmente a classe (ex: `new Livro(...)`). Um ORM faz esse mapeamento objeto-relacional de maneira transparente e automática nos bastidores.

3. **Gestão de Ciclo de Vida e Relacionamentos:**
   Os ORMs gerenciam estados de entidades (através de conceitos como *Unit of Work*), monitoram alterações de propriedades automaticamente e resolvem relacionamentos complexos (como 1 para N ou N para N) por meio de configurações ou atributos. O nosso *Repository* apenas delega operações de persistência e consultas estáticas, sem gerir o estado relacional dos objetos na memória.

Em suma: O uso de **PDO** aliado a um **Repository** constitui uma excelente prática de arquitetura em camadas e separação de responsabilidades, mas continua a ser uma abordagem baseada em dados relacionais (*data-mapper manual*), diferindo profundamente da automação estrutural completa de um ORM.