<?php
include 'conexao.php';

mysqli_query($conn, "INSERT INTO usuarios(nome,email,telefone,idade,cidade,curso) 
VALUES (
  '$_POST[nome]',
  '$_POST[email]',
  '$_POST[telefone]',
  '$_POST[idade]',
  '$_POST[cidade]',
  '$_POST[curso]'
)");

if(
    empty($_POST['nome']) ||
    empty($_POST['email']) ||
    empty($_POST['telefone'])||
    empty($_POST['idade']) ||
    empty($_POST['cidade']) ||
    empty($_POST['curso']) 
){
    die("Preencha todos os campos obrigatórios.");
}

header("Location: index.php");
?>