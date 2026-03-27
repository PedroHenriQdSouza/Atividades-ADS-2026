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
        $dadosVeiculo = $pdo->query("SELECT * FROM dadosveiculo");
        // script sql para pegar todos os valores que estão na tabela dadosveículo
        $carros = $dadosVeiculo->fetchAll(PDO::FETCH_ASSOC); // FetchAll serve para Agrupar todos os valores em uma array

        // Verifica se o array de carros está vazio
        if (empty($carros)) {
            echo "<p>Nenhum carro fabricado.</p>";
        } else {
            // Loop foreach para cada carro que tiver na array
        ?>
            <table class="titulo_tabela">
                <thead>
                    <tr class="titulo_col">
                        <!--<th>Sr#</th>--->
                        <th>ID</th> <!----nome dos campos da tabela exemplo nome  idade  e-maail da tabela crud editar e deletar--->
                        <th>Nome do Carro</th>
                        <th>Cor do Carro</th>
                        <th class="text-center">Data do registro</th>
                    </tr>
                </thead>

            </table>
            <tbody>

            <?php
            foreach ($carros as $carro) {
                echo "<td>{$carro['Nome']}</td><td>{$carro['Cor']}<td><br>";
            }
        }
            ?>
            </tbody>
    </div>
    <a href="../Public/index.html"><button class="voltar" type="return">Voltar</button></a>
    <footer></footer>
</body>

</html>