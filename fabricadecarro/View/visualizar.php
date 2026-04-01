<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Importa o arquivo que conecta com o banco de dados (trazendo o $pdo e o $db)
require_once '../Database/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Public/css/estilo.css">
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
        <div class="Lista">
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
    </div>
    <a href="../Public/index.html"><button class="voltar" type="return">Voltar</button></a>
    <footer></footer>
</body>

</html>