<?php
// ------------------------------------------------------------
// ARQUIVO: auth.php
// RESPONSABILIDADE:
// Centralizar autenticacao simples com sessao e banco de dados.
// ------------------------------------------------------------

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// Redireciona com mensagem na URL.
function auth_redirect_with_alert($url, $status, $message) {
  header('Location: ' . $url . '?status=' . urlencode($status) . '&msg=' . urlencode($message));
  exit;
}

// Garante tabela de login e usuario admin inicial.
function ensure_auth_table($conn) {
  $sqlCreate = "CREATE TABLE IF NOT EXISTS usuarios_login (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_usuarios_login_email (email)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

  mysqli_query($conn, $sqlCreate);

  $emailAdmin = 'admin@admin.com';
  $stmtCheck = mysqli_prepare($conn, 'SELECT id FROM usuarios_login WHERE email = ? LIMIT 1');
  if (!$stmtCheck) {
    return;
  }

  mysqli_stmt_bind_param($stmtCheck, 's', $emailAdmin);
  mysqli_stmt_execute($stmtCheck);
  $res = mysqli_stmt_get_result($stmtCheck);
  $exists = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmtCheck);

  if ($exists) {
    return;
  }

  $nomeAdmin = 'Administrador';
  $senhaPadrao = '123456';
  $senhaHash = password_hash($senhaPadrao, PASSWORD_DEFAULT);

  $stmtInsert = mysqli_prepare($conn, 'INSERT INTO usuarios_login (nome, email, senha_hash) VALUES (?, ?, ?)');
  if (!$stmtInsert) {
    return;
  }

  mysqli_stmt_bind_param($stmtInsert, 'sss', $nomeAdmin, $emailAdmin, $senhaHash);
  mysqli_stmt_execute($stmtInsert);
  mysqli_stmt_close($stmtInsert);
}

function is_user_logged_in() {
  return isset($_SESSION['auth_user_id']);
}

// Exige usuario logado para executar acoes restritas.
function require_login($redirectUrl = 'index.php') {
  if (!is_user_logged_in()) {
    auth_redirect_with_alert($redirectUrl, 'error', 'Voce precisa estar logado para editar ou excluir.');
  }
}

function get_logged_user_name() {
  return $_SESSION['auth_user_nome'] ?? '';
}

function login_user($user) {
  $_SESSION['auth_user_id'] = (int)$user['id'];
  $_SESSION['auth_user_nome'] = $user['nome'];
  $_SESSION['auth_user_email'] = $user['email'];
}

function attempt_login($conn, $email, $senha) {
  $stmt = mysqli_prepare($conn, 'SELECT id, nome, email, senha_hash FROM usuarios_login WHERE email = ? LIMIT 1');
  if (!$stmt) {
    return null;
  }

  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);

  if (!$user) {
    return null;
  }

  if (!password_verify($senha, $user['senha_hash'])) {
    return null;
  }

  return $user;
}

function logout_user() {
  $_SESSION = [];

  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
      session_name(),
      '',
      time() - 42000,
      $params['path'],
      $params['domain'],
      $params['secure'],
      $params['httponly']
    );
  }

  session_destroy();
}
?>