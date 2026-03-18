<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';

// Support PRG: accept data from POST or from session realizando_fabricacao
$data = $_POST;
if (empty($data) && !empty($_SESSION['realizando_fabricacao'])) {
    $data = $_SESSION['realizando_fabricacao'];
    unset($_SESSION['realizando_fabricacao']);
}

$qtdeCarros = (int)($data['qtdeCarros'] ?? 0);

if (!isset($_SESSION['fabrica'])) {
    $_SESSION['fabrica'] = serialize(new Fabrica());
}

$fabrica = unserialize($_SESSION['fabrica']);
$carros = [];

if ($qtdeCarros > 0) {
    for ($i = 1; $i <= $qtdeCarros; $i++) {
        $carro = new Carro();
        $carro->setModelo($data["modelo_{$i}"] ?? '');
        $carro->setCor($data["cor_{$i}"] ?? '');
        $carros[] = $carro;
    }

    $fabrica->fabricarCarro($carros);
    $_SESSION['fabrica'] = serialize($fabrica);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Public/css/estilo.css">
    <title>Carros Fabricados</title>
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
        <h1>Carros fabricados com sucesso!</h2>

        <?php
        foreach ($fabrica->getListaDeCarros() as $carro) {
            echo "<p>Modelo: {$carro->getModelo()} | Cor: {$carro->getCor()}</p>";
        }
        ?>
    </div>
    <a href="../Public/index.html"><button class="voltar">Voltar</button></a>

    <footer></footer>
</body>

</html>