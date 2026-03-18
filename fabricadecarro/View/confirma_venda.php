<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';


$data = $_POST;
if (empty($data) && !empty($_SESSION['realizando_venda'])) {
    $data = $_SESSION['realizando_venda'];
    unset($_SESSION['realizando_venda']);
}

$modelo = $data['modelo'] ?? '';
$cor = $data['cor'] ?? '';

$fabrica = unserialize($_SESSION['fabrica'] ?? serialize(new Fabrica()));

$sucesso = false;
$mensagem = null;
if ($modelo !== '' || $cor !== '') {
    $sucesso = $fabrica->venderCarro($modelo, $cor);
    $_SESSION['fabrica'] = serialize($fabrica);
} else {
    $mensagem = 'Nenhuma venda pendente.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Public/css/estilo.css">
    <title>Venda de Carro</title>
</head>

<body>
    <header>
        <div class="logo"><a href="../Public/index.html"><img src="../Public/home.png" alt=""></a></div>
        <div class="navbar">
            <nav>
                <a href="../View/fabricar.php">Fabricar Carros</a>
                <a href="../View/vender.php">Vender Carro</a>
                <a href="../View/visualizar.php">Ver Carros</a>
            </nav>
        </div>
    </header>

    <div class="banner"></div>
    <div class="fundo">
        <div class="popup">
            <?php if (!empty($mensagem)): ?>
                <h1 style="text-align: center;" class="titulo">⚠️ <?php echo $mensagem; ?></h1>
                <?php elseif ($sucesso): ?>
                    <h1 style="text-align: center;" class="titulo">Carro vendido com sucesso!</h1>
                    <?php else: ?>
                        <h1 style="text-align: center;" class="titulo">❌ Carro não encontrado.</h1>
                        <?php endif; ?>

                        <a href="../View/vender.php"><button type="return" class="voltar">Voltar</button></a>
        </div>
        
    </div>
    <footer></footer>
</body>

</html>