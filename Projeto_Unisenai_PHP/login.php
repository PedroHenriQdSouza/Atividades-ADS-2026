<?php
// ------------------------------------------------------------
// ARQUIVO: login.php
// RESPONSABILIDADE:
// Exibir formulario e autenticar usuario no sistema.
// ------------------------------------------------------------

include 'conexao.php';
include_once 'auth.php';

ensure_auth_table($conn);

if (is_user_logged_in()) {
  auth_redirect_with_alert('index.php', 'success', 'Voce ja esta logado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $senha = $_POST['senha'] ?? '';

  if ($email === '' || $senha === '') {
    auth_redirect_with_alert('login.php', 'error', 'Preencha email e senha.');
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    auth_redirect_with_alert('login.php', 'error', 'Informe um email valido.');
  }

  $user = attempt_login($conn, $email, $senha);
  if (!$user) {
    auth_redirect_with_alert('login.php', 'error', 'Credenciais invalidas.');
  }

  login_user($user);
  auth_redirect_with_alert('index.php', 'success', 'Login realizado com sucesso.');
}

$pageTitle = 'Login de Usuarios';
$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
include 'includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-12 col-md-7 col-lg-5">
    <?php if ($msg !== ''): ?>
      <?php $isSuccess = $status === 'success'; ?>
      <div class="alert <?php echo $isSuccess ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <h1 class="h5 mb-0"><i class="bi bi-box-arrow-in-right me-2"></i>Login</h1>
      </div>
      <div class="card-body">
        <p class="text-muted small mb-3">
          Usuario inicial: admin@admin.com | Senha: 123456
        </p>

        <form method="POST" action="login.php" class="row g-3">
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" required>
          </div>

          <div class="col-12">
            <label for="senha" class="form-label">Senha</label>
            <input id="senha" class="form-control" type="password" name="senha" required>
          </div>

          <div class="col-12 d-grid">
            <button class="btn btn-primary" type="submit">Entrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>