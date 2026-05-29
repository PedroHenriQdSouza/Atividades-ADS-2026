<?php
include 'conexao.php';
include_once 'auth.php';

require_login('index.php');

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$idade = $_POST['idade'];
$cidade = $_POST['cidade'];
$curso = $_POST['curso'];

$sql = "UPDATE usuarios SET 
  nome='$nome',
  email='$email',
  telefone='$telefone',
  idade='$idade',
  cidade='$cidade',
  curso='$curso'
WHERE id=$id";

mysqli_query($conn, $sql);

header("Location: index.php");
?>