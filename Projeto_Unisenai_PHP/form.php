<?php 

//Variavel usada no <title> da pagina ( header.php)
$pageTitle = "Cadastro de um novo usuário";

//inclui no topo da pagina (HTML Inicial + navbar)
include 'includes/header.php';

?>


<div class="card shadow-sm">
  <div class="card-header bg-white">
    <h2 class="h5 mb-0"><i class="bi bi-person-plus"></i>Novo Usuario</h2>
  </div>
  <div class="card-body">
  <form method="POST" action="salvar.php">
    <div class="col-12">
      <label for="nome" class="form-label">Nome</label>
      <input type="text" class="form-control" name="nome">
    </div>
    <div class="col-12 col-md-6">
    <label for="email" class="form-label"> Email:</label>
    <input type="email" class="form-control"  name="email">
    </div>

    <label for="telefone" class="form-label"> Telefone:</label>
    <input type="text" class="form-control"  name="telefone">
    Idade: <input type="number" class="form-control"  min="1" name="idade">
    Cidade: <input type="text" class="form-control"  name="cidade">
    Curso: <input type="text" class="form-control"  name="curso">

    <button type="submit" class="btn btn-outline-primary mt-3">Salvar</button>
  </form>
  </div>
</div>
