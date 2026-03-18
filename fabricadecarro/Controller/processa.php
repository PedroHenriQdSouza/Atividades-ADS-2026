<?php
session_start();
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    switch ($acao) {
        case 'fabricar':

            header('Location: ../view/fabricar.php');
            break;

        case 'definir_carros':

            $qtdeCarros = (int)($_POST['qtdeCarros'] ?? 0);
            header("Location: ../view/definir_carros.php?qtdeCarros={$qtdeCarros}");
            break;

        case 'finalizar_fabricacao':

            $_SESSION['realizando_fabricacao'] = $_POST;
            header('Location: ../view/finalizar_fabrica.php');
            exit;

        case 'vender':

            header('Location: ../view/vender.php');
            break;

        case 'confirmar_venda':

            $_SESSION['realizando_venda'] = $_POST;
            header('Location: ../view/confirma_venda.php');
            exit;

        case 'ver':

            header('Location: ../view/visualizar.php');
            exit;

        case 'limpar_sessao':

            session_destroy();
            header('Location: ../view/encerrar_sessao.php');
            break;

        default:

            echo "<h2>❌ Ação inválida.</h2>";
            echo '<a href="index.html">🔙 Voltar ao menu</a>';
            break;
    }
} else {
    echo "<h2>⚠️ Nenhuma ação recebida.</h2>";
    echo '<a href="../public/index.html">🔙 Voltar ao menu</a>';
}
