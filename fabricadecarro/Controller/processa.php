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
            require_once '../Database/config.php';
            // Pega a quantidade de carros que o usuário preencheu
            $qtdeCarros = (int)($_POST['qtdeCarros'] ?? 0);

            // Loop para salvar cada carro gerado no formulário
            for ($i = 1; $i <= $qtdeCarros; $i++) {
                $modelo = $_POST["modelo_{$i}"] ?? '';
                $cor    = $_POST["cor_{$i}"] ?? '';

                if (!empty($modelo) && !empty($cor)) {
                    // Monta o array com os nomes das colunas da tabela dadosveiculo
                    $data = array(
                        'Nome' => $modelo,
                        'Cor'  => $cor
                        
                    );

                    $db->insert('dadosveiculo', $data);
                }
            }
            $_SESSION['realizando_fabricacao'] = $_POST;
            header('Location: ../view/finalizar_fabrica.php');
            exit;
        case 'vender':

            header('Location: ../view/vender.php');
            break;

        case 'confirmar_venda':
            require_once '../Database/config.php';

            $modelo = $_POST['modelo'] ?? '';
            $cor    = $_POST['cor'] ?? '';
            
            $comando_sql = "DELETE FROM dadosveiculo WHERE Nome = '$modelo' AND Cor = '$cor' LIMIT 1";

            $db->deleteQry($comando_sql);
            $_SESSION['realizando_venda'] = $_POST;
            header('Location: ../view/confirma_venda.php');
            exit;

        case 'ver':

            header('Location: ../view/visualizar.php');
            exit;

        case 'limpar_sessao':

            require_once '../Database/config.php';

            $db->deleteQry('TRUNCATE TABLE dadosveiculo'); //o metodo deleteQry para inserir uma função no sql
            //TRUNCATE TABLE é um código SQL que serve para excluir todas as linhas da tabela e resetar os IDs
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
