<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aluno_id = $_POST['aluno_id'];
    $bimestre = $_POST['bimestre'];
    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $nota3 = $_POST['nota3'];
    $peso = $_POST['peso'];
    $faltas = $_POST['faltas'];

    $sql = "INSERT INTO notas_alunos (aluno_id, bimestre, nota1, nota2, nota3, peso, faltas) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("isddddi", $aluno_id, $bimestre, $nota1, $nota2, $nota3, $peso, $faltas);
        if ($stmt->execute()) {
            header("Location: notas_index.php?sucesso=1");
            exit;
        } else {
            echo "Erro ao salvar notas: " . $stmt->error;
        }
    }
}
?>