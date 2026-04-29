<?php
require 'conexao.php';
$resultado = $conn->query("SELECT * FROM usuarios ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Lista de Alunos</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="index.php">Sistema Escolar</a>
      <div class="navbar-nav">
        <a class="nav-link" href="index.php">Cadastrar</a>
        <a class="nav-link active" href="listar.php">Listar Alunos</a>
      </div>
    </nav>

    <div class="container-fluid">
        <h2 class="mb-4">Alunos Cadastrados</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Idade</th>
                        <th>Cidade</th>
                        <th>Curso</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $linha['id'] ?></td>
                        <td><?= htmlspecialchars($linha['nome']) ?></td>
                        <td><?= htmlspecialchars($linha['email']) ?></td>
                        <td><?= htmlspecialchars($linha['telefone']) ?></td>
                        <td><?= $linha['idade'] ?></td>
                        <td><?= htmlspecialchars($linha['cidade']) ?></td>
                        <td><?= htmlspecialchars($linha['curso']) ?></td>
                        <td class="text-center">
                            <a href="editar.php?id=<?= $linha['id'] ?>" class="btn btn-sm btn-info">Editar</a>
                            <a href="excluir.php?id=<?= $linha['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>