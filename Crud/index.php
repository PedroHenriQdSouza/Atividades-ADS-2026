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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro de Alunos</title>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Sistema Escolar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link active" href="index.php">Cadastrar Aluno</a>
                    <a class="nav-link" href="listar.php">Listar Alunos</a>
                    <a class="nav-link" href="notas_index.php">Notas e Boletins</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Novo Cadastro</h5>
                    </div>
                    <div class="card-body">
                        <?= $mensagem ?>
                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Idade</label>
                                    <input type="number" name="idade" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="cidade" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Curso</label>
                                <input type="text" name="curso" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Salvar Registro</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>