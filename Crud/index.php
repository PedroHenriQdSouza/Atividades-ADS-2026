<?php
require 'conexao.php';
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $idade = $_POST['idade'];
    $cidade = $_POST['cidade'];
    $curso = $_POST['curso'];

    $sql = "INSERT INTO usuarios (nome, email, telefone, idade, cidade, curso) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssiss", $nome, $email, $telefone, $idade, $cidade, $curso);
        if ($stmt->execute()) {
            $mensagem = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Cadastro de Alunos</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="index.php">Sistema Escolar</a>
      <div class="navbar-nav">
        <a class="nav-link active" href="index.php">Cadastrar</a>
        <a class="nav-link" href="listar.php">Listar Alunos</a>
      </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white"><h5>Novo Cadastro</h5></div>
                    <div class="card-body">
                        <?= $mensagem ?>
                        <form method="POST" action="index.php">
                            <div class="form-group">
                                <label>Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Idade</label>
                                    <input type="number" name="idade" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" name="cidade" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Curso</label>
                                <input type="text" name="curso" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Salvar Registro</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>