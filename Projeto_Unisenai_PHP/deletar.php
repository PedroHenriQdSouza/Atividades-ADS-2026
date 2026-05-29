<?php
include 'conexao.php';
include_once 'auth.php';

require_login('index.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Erro ao excluir: " . mysqli_error($conn);
    }
}
?>