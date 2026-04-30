<?php
require 'conexao.php';
// Busca os alunos para preencher o select
$alunos = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lançar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Sistema Escolar</a>
        <div class="navbar-nav">
          <a class="nav-link" href="index.php">Cadastrar Aluno</a>
          <a class="nav-link" href="listar.php">Listar Alunos</a>
          <a class="nav-link active" href="notas_index.php">Notas e Boletins</a>
        </div>
      </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm col-md-8 mx-auto">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Lançar Notas do Bimestre</h5>
            </div>
            <div class="card-body">
                <form action="notas_salvar.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Aluno</label>
                        <select name="aluno_id" class="form-select" required>
                            <option value="">Selecione um aluno...</option>
                            <?php while($aluno = $alunos->fetch_assoc()): ?>
                                <option value="<?= $aluno['id'] ?>"><?= htmlspecialchars($aluno['nome']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bimestre</label>
                        <select name="bimestre" class="form-select" required>
                            <option value="1º Bimestre">1º Bimestre</option>
                            <option value="2º Bimestre">2º Bimestre</option>
                            <option value="3º Bimestre">3º Bimestre</option>
                            <option value="4º Bimestre">4º Bimestre</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Nota 1</label>
                            <input type="number" step="0.01" name="nota1" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nota 2</label>
                            <input type="number" step="0.01" name="nota2" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nota 3</label>
                            <input type="number" step="0.01" name="nota3" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Peso (Padrão 1.00)</label>
                            <input type="number" step="0.01" name="peso" class="form-control" value="1.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Faltas</label>
                            <input type="number" name="faltas" class="form-control" value="0" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Salvar Notas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>