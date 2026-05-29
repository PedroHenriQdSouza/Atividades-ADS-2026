# Atividade Extra - Entrega na Proxima Quinta

## Tema
Agenda de Alunos com Notas e Medias (CRUD + Calculos)

## Contexto
Vocês vao criar uma extensao do projeto atual (CRUD de usuarios) para controlar **notas de alunos** e praticar operacoes matematicas em PHP:

- soma
- subtracao
- multiplicacao
- divisao

A ideia e montar uma pequena agenda academica com alunos, notas por bimestre, media e situacao.

## Objetivos de Aprendizagem
- Criar e relacionar tabelas no MySQL.
- Trabalhar com formularios HTML + Bootstrap 5.
- Salvar e listar dados no PHP com MySQLi.
- Aplicar funcoes/operacoes matematicas para calcular resultados.
- Exibir feedback visual de sucesso/erro.

---

## Parte 1 - Banco de Dados
Crie a tabela `notas_alunos` no mesmo banco do projeto.

### Exercicio 1
Crie a tabela `notas_alunos` com os campos:
- `id` (PK, auto incremento)
- `aluno_id` (inteiro, obrigatorio)
- `bimestre` (varchar 20)
- `nota1` (decimal 5,2)
- `nota2` (decimal 5,2)
- `nota3` (decimal 5,2)
- `peso` (decimal 4,2, padrao 1.00)
- `faltas` (inteiro, padrao 0)
- `created_at` (timestamp, default current_timestamp)

### Exercicio 2
Adicione a chave estrangeira de `aluno_id` para `usuarios(id)`.

---

## Parte 2 - Telas e Navegacao
### Exercicio 3
Adicione no menu uma nova pagina chamada **Notas**.

### Exercicio 4
Crie `notas_form.php` com formulario Bootstrap para cadastrar notas:
- aluno (select carregado da tabela `usuarios`)
- bimestre
- nota1, nota2, nota3
- peso
- faltas

---

## Parte 3 - Regras de Calculo
Implemente os calculos no backend (arquivo `notas_salvar.php`).

### Exercicio 5
Calcule e exiba na listagem:
- `soma_notas = nota1 + nota2 + nota3`
- `media_simples = soma_notas / 3`

### Exercicio 6
Calcule tambem a media ponderada:
- `media_ponderada = ((nota1 + nota2 + nota3) / 3) * peso`

### Exercicio 7
Exiba a diferenca para meta 7.0:
- `diferenca_meta = 7.0 - media_simples`
- Se a media for maior ou igual a 7, mostrar `0`.

### Exercicio 8
Classifique o aluno:
- Aprovado: media >= 7.0 e faltas <= 10
- Recuperacao: media entre 5.0 e 6.99
- Reprovado: media < 5.0 ou faltas > 10

---

## Parte 4 - Listagem e Relatorios
### Exercicio 9
Crie `notas_index.php` com tabela Bootstrap mostrando:
- Nome do aluno
- Bimestre
- Nota1, Nota2, Nota3
- Soma
- Media simples
- Media ponderada
- Faltas
- Situacao

### Exercicio 10
No topo da tabela, mostre cards com resumo:
- Quantidade total de lancamentos
- Maior media da turma
- Menor media da turma
- Media geral da turma

---

## Parte 5 - Extras (Bonus)
### Exercicio 11 (bonus)
Permita editar um lancamento de notas (`notas_editar.php` + `notas_atualizar.php`).

### Exercicio 12 (bonus)
Permita excluir um lancamento (`notas_deletar.php`) com confirmacao.

### Exercicio 13 (bonus)
Crie filtro por bimestre e por nome do aluno na listagem.

---

## Requisitos Tecnicos
- Usar Bootstrap 5 e Bootstrap Icons.
- Usar prepared statements (MySQLi).
- Validar campos obrigatorios e faixa de nota (0 a 10).
- Exibir alertas de sucesso/erro (evitar tela crua com erro SQL).

## Entrega
Entregar ate quinta-feira:
1. Codigo completo no projeto.
2. Dump SQL da tabela `notas_alunos`.
3. Prints de tela:
- cadastro de notas
- listagem com calculos
- exemplo de aprovado/recuperacao/reprovado
4. Breve explicacao (5 a 10 linhas) sobre como calcularam media e situacao.

---

# Gabarito (Professor)

> Use esta secao como referencia. Os alunos nao precisam copiar literalmente.

## 1) SQL sugerido

```sql
CREATE TABLE notas_alunos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aluno_id INT NOT NULL,
  bimestre VARCHAR(20) NOT NULL,
  nota1 DECIMAL(5,2) NOT NULL,
  nota2 DECIMAL(5,2) NOT NULL,
  nota3 DECIMAL(5,2) NOT NULL,
  peso DECIMAL(4,2) NOT NULL DEFAULT 1.00,
  faltas INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notas_aluno
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
```

## 2) Regras de validacao (referencia)
- aluno_id obrigatorio e inteiro.
- bimestre obrigatorio.
- notas entre 0 e 10.
- faltas maior ou igual a 0.
- peso maior que 0.

## 3) Formulas (referencia)

```php
$soma = $nota1 + $nota2 + $nota3;
$mediaSimples = $soma / 3;
$mediaPonderada = $mediaSimples * $peso;
$diferencaMeta = max(0, 7.0 - $mediaSimples);
```

## 4) Regra de situacao (referencia)

```php
if ($mediaSimples >= 7.0 && $faltas <= 10) {
    $situacao = 'Aprovado';
} elseif ($mediaSimples >= 5.0 && $mediaSimples < 7.0) {
    $situacao = 'Recuperacao';
} else {
    $situacao = 'Reprovado';
}
```

## 5) INSERT com prepared statement (referencia)

```php
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO notas_alunos (aluno_id, bimestre, nota1, nota2, nota3, peso, faltas)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    'isddddi',
    $alunoId,
    $bimestre,
    $nota1,
    $nota2,
    $nota3,
    $peso,
    $faltas
);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
```

## 6) SELECT de listagem (referencia)

```sql
SELECT
  n.id,
  u.nome AS aluno_nome,
  n.bimestre,
  n.nota1,
  n.nota2,
  n.nota3,
  n.peso,
  n.faltas,
  (n.nota1 + n.nota2 + n.nota3) AS soma_notas,
  ((n.nota1 + n.nota2 + n.nota3) / 3) AS media_simples,
  (((n.nota1 + n.nota2 + n.nota3) / 3) * n.peso) AS media_ponderada
FROM notas_alunos n
INNER JOIN usuarios u ON u.id = n.aluno_id
ORDER BY n.id DESC;
```

## 7) Exemplo de cards de resumo (referencia SQL)

```sql
SELECT
  COUNT(*) AS total_lancamentos,
  MAX((nota1 + nota2 + nota3) / 3) AS maior_media,
  MIN((nota1 + nota2 + nota3) / 3) AS menor_media,
  AVG((nota1 + nota2 + nota3) / 3) AS media_geral
FROM notas_alunos;
```

## 8) Criterio de avaliacao sugerido (10 pontos)
- 2.0: criacao correta da tabela e relacionamento.
- 2.0: formulario funcional com validacoes.
- 2.0: uso de prepared statements.
- 2.0: calculos corretos (soma, media, media ponderada, diferenca).
- 1.0: classificacao correta (aprovado/recuperacao/reprovado).
- 1.0: organizacao visual com Bootstrap e navegacao.
