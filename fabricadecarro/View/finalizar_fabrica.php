<?php

require_once '../Database/config.php';
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';

$data = $_POST;
if (empty($data) && !empty($_SESSION['realizando_fabricacao'])) {
    $data = $_SESSION['realizando_fabricacao'];
    unset($_SESSION['realizando_fabricacao']);
}

$qtdeCarros = (int)($data['qtdeCarros'] ?? 0);




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
            $dadosVeiculo = $pdo->query("SELECT * FROM dadosveiculo");
            $carros = $dadosVeiculo->fetchAll(PDO::FETCH_ASSOC);

            if (empty($carros)) {
                echo "<p>Nenhum carro fabricado.</p>";
            } else {
            ?>
                <table>
                    <thead>
                        <tr class="titulo_col">
                            <th>ID</th>
                            <th>Nome do Carro</th>
                            <th>Cor do Carro</th>
                            <th>Data do registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carros as $carro): ?>
                            <tr>
                                <td><?= $carro['id'] ?></td>
                                <td><?= $carro['Nome'] ?></td>
                                <td><?= $carro['Cor'] ?></td>
                                <td><?= $carro['Data_registro'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            }
            ?>
    </div>
    <a href="../Public/index.html"><button class="voltar">Voltar</button></a>

    <footer></footer>
</body>

</html>