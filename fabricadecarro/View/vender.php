<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../Database/config.php';
require_once '../Model/Fabrica.php';
require_once '../Model/Carro.php';
$fabrica = unserialize($_SESSION['fabrica'] ?? serialize(new Fabrica()));
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Public/css/estilo.css">
    <title>Vender Carro</title>
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

        <h1>Vender Veículo</h1>
        <div class="container">
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

            <div class="menu-container3">
                <form class="form2" action='../Controller/processa.php' method="POST">
                    <input type="hidden" name="acao" value="confirmar_venda">

                    <label>Modelo do carro:</label><br>
                    <input type="text" name="modelo" required><br>

                    <label>Cor do carro:</label><br>
                    <input type="text" name="cor" required><br><br>

                    <button class="proximo" type="submit">Vender</button>
                </form>
            </div>
        </div>
    </div>

    <footer></footer>
</body>

</html>