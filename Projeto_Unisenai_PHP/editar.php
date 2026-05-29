<?php
include 'conexao.php';
include_once 'auth.php';

require_login('index.php');

//Variavel usada no <title> da pagina ( header.php)
$pageTitle = "Edição de Usuário";

//inclui no topo da pagina (HTML Inicial + navbar)
include 'includes/header.php';

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
$dados = mysqli_fetch_assoc($res);
?>

<h2>Editar Usuário</h2>

<form action="atualizar.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">

  Nome: <br>
  <input type="text" name="nome" value="<?php echo $dados['nome']; ?>"><br><br>

  Email: <br>
  <input type="email" name="email" value="<?php echo $dados['email']; ?>"><br><br>

  Telefone: <br>
  <input type="text" name="telefone" value="<?php echo $dados['telefone']; ?>"><br><br>

  Idade: <br>
  <input type="number" name="idade" value="<?php echo $dados['idade']; ?>"><br><br>

  Cidade: <br>
  <input type="text" name="cidade" value="<?php echo $dados['cidade']; ?>"><br><br>

  Curso: <br>
  <input type="text" name="curso" value="<?php echo $dados['curso']; ?>"><br><br>

  <button type="submit">Atualizar</button>
</form>