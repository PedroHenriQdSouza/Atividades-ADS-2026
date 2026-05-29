<?php
// ------------------------------------------------------------
// ARQUIVO: logout.php
// RESPONSABILIDADE:
// Encerrar sessao do usuario.
// ------------------------------------------------------------

include_once 'auth.php';

logout_user();
auth_redirect_with_alert('index.php', 'success', 'Logout realizado com sucesso.');
?>