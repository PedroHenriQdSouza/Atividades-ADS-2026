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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Editar Aluno</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="index.php">Sistema Escolar</a>
    </nav>

    <div class="container">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5>Editar Registro #<?= $id ?></h5></div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group"><label>Nome</label><input type="text" name="nome" class="form-control" value="<?= $usuario['nome'] ?>" required></div>
                        <div class="form-group"><label>E-mail</label><input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required></div>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Telefone</label><input type="text" name="telefone" class="form-control" value="<?= $usuario['telefone'] ?>" required></div>
                            <div class="form-group col-md-6"><label>Idade</label><input type="number" name="idade" class="form-control" value="<?= $usuario['idade'] ?>" required></div>
                        </div>
                        <div class="form-group"><label>Cidade</label><input type="text" name="cidade" class="form-control" value="<?= $usuario['cidade'] ?>" required></div>
                        <div class="form-group"><label>Curso</label><input type="text" name="curso" class="form-control" value="<?= $usuario['curso'] ?>" required></div>
                        <button type="submit" class="btn btn-info btn-block">Atualizar Dados</button>
                        <a href="listar.php" class="btn btn-secondary btn-block">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>