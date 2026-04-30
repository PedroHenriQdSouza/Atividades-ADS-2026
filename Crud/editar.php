<?php
require 'conexao.php';
$id = $_GET['id'];

// Busca os dados atuais
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $idade = $_POST['idade'];
    $cidade = $_POST['cidade'];
    $curso = $_POST['curso'];

    $sql = "UPDATE usuarios SET nome=?, email=?, telefone=?, idade=?, cidade=?, curso=? WHERE id=?";
    $stmt_update = $conn->prepare($sql);
    $stmt_update->bind_param("sssissi", $nome, $email, $telefone, $idade, $cidade, $curso, $id);
    
    if ($stmt_update->execute()) {
        header("Location: listar.php");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Aluno</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Sistema Escolar</a>
      </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Editar Registro #<?= $id ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($usuario['telefone']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Idade</label>
                                    <input type="number" name="idade" class="form-control" value="<?= $usuario['idade'] ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="cidade" class="form-control" value="<?= htmlspecialchars($usuario['cidade']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Curso</label>
                                <input type="text" name="curso" class="form-control" value="<?= htmlspecialchars($usuario['curso']) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-info w-100 mb-2 text-white">Atualizar Dados</button>
                            <a href="listar.php" class="btn btn-secondary w-100">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>