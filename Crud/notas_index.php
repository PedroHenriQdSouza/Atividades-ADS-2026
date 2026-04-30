<?php
require 'conexao.php';

// Busca cruzando a tabela de notas com a tabela de alunos (usuarios)
$sql = "SELECT n.*, u.nome FROM notas_alunos n JOIN usuarios u ON n.aluno_id = u.id ORDER BY n.id DESC";
$resultado = $conn->query($sql);

// Variáveis para os Cards de Resumo (Exercicio 10)
$total_lancamentos = $resultado->num_rows;
$max_media = 0;
$min_media = 10;
$soma_geral_medias = 0;

$dados_tabela = [];

// Loop para realizar os cálculos (Exercícios 5 a 8)
if ($total_lancamentos > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $n1 = $row['nota1'];
        $n2 = $row['nota2'];
        $n3 = $row['nota3'];
        $peso = $row['peso'];
        $faltas = $row['faltas'];

        // Ex 5: Soma e Média Simples
        $soma_notas = $n1 + $n2 + $n3;
        $media_simples = $soma_notas / 3;

        // Ex 6: Média Ponderada
        $media_ponderada = ($soma_notas / 3) * $peso;

        // Ex 7: Diferença para meta 7.0
        $diferenca_meta = 7.0 - $media_simples;
        if ($diferenca_meta < 0) {
            $diferenca_meta = 0;
        }

        // Ex 8: Classificação do aluno
        if ($media_simples >= 7.0 && $faltas <= 10) {
            $situacao = "Aprovado";
            $badge = "success";
        } elseif ($media_simples < 5.0 || $faltas > 10) {
            $situacao = "Reprovado";
            $badge = "danger";
        } else {
            $situacao = "Recuperação";
            $badge = "warning";
        }

        // Estatísticas para os cards
        if ($media_simples > $max_media) {
            $max_media = $media_simples;
        }
        if ($media_simples < $min_media) {
            $min_media = $media_simples;
        }
        $soma_geral_medias += $media_simples;

        // Guarda os dados calculados para exibir na tabela depois
        $row['soma'] = $soma_notas;
        $row['media_simples'] = $media_simples;
        $row['media_ponderada'] = $media_ponderada;
        $row['diferenca'] = $diferenca_meta;
        $row['situacao'] = $situacao;
        $row['badge'] = $badge;

        $dados_tabela[] = $row;
    }
} else {
    $min_media = 0; // zera se não tiver registros
}

$media_geral_turma = $total_lancamentos > 0 ? ($soma_geral_medias / $total_lancamentos) : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boletins e Notas</title>
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

    <div class="container-fluid px-4">

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Notas lançadas com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gestão de Notas</h2>
            <a href="notas_form.php" class="btn btn-success">+ Lançar Notas</a>
        </div>

        <div class="row mb-4 text-center">
            <div class="col-md-3">
                <div class="card text-bg-primary shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Lançamentos</h6>
                        <h3><?= $total_lancamentos ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-success shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Maior Média</h6>
                        <h3><?= number_format($max_media, 2, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Menor Média</h6>
                        <h3><?= number_format($min_media, 2, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-info text-white shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Média Geral</h6>
                        <h3><?= number_format($media_geral_turma, 2, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive shadow-sm bg-white p-3 rounded">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Aluno</th>
                        <th>Bimestre</th>
                        <th>N1</th>
                        <th>N2</th>
                        <th>N3</th>
                        <th>Faltas</th>
                        <th>Soma</th>
                        <th>Média (S)</th>
                        <th>Média (P)</th>
                        <th>Falta p/ Meta</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dados_tabela)): ?>
                        <tr>
                            <td colspan="11">Nenhuma nota lançada.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dados_tabela as $linha): ?>
                            <tr>
                                <td class="text-start fw-bold"><?= htmlspecialchars($linha['nome']) ?></td>
                                <td><?= $linha['bimestre'] ?></td>
                                <td><?= number_format($linha['nota1'], 2, ',', '.') ?></td>
                                <td><?= number_format($linha['nota2'], 2, ',', '.') ?></td>
                                <td><?= number_format($linha['nota3'], 2, ',', '.') ?></td>
                                <td><?= $linha['faltas'] ?></td>
                                <td class="text-muted"><?= number_format($linha['soma'], 2, ',', '.') ?></td>
                                <td class="fw-bold"><?= number_format($linha['media_simples'], 2, ',', '.') ?></td>
                                <td><?= number_format($linha['media_ponderada'], 2, ',', '.') ?></td>
                                <td class="text-danger"><?= $linha['diferenca'] == 0 ? '-' : number_format($linha['diferenca'], 2, ',', '.') ?></td>
                                <td><span class="badge bg-<?= $linha['badge'] ?>"><?= $linha['situacao'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>