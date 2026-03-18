<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';
$fabrica = unserialize($_SESSION['fabrica'] ?? serialize(new Fabrica()));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/css/estilo.css">
    <title>Carros da Fábrica</title>
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

    <div class="menu-container2">
        <h1>Carros da Fábrica</h1>

        <?php
        if (empty($fabrica->getListaDeCarros())) {
            echo "<p>Nenhum carro fabricado.</p>";
        } else {
            foreach ($fabrica->getListaDeCarros() as $carro) {
                echo "<p>Modelo: {$carro->getModelo()} | Cor: {$carro->getCor()}</p>";
            }
        }
        ?>
    </div>
        <a href="../Public/index.html"><button class="voltar" type="return">Voltar</button></a>
    <footer></footer>
</body>

</html>
