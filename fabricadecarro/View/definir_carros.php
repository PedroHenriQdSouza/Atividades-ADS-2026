<?php
$qtdeCarros = (int)($_GET['qtdeCarros'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Public/css/estilo.css">
    <title>Definir Carros</title>
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
        <form class="form2" action='../Controller/processa.php' method='POST'>
            <input type='hidden' name='acao' value='finalizar_fabricacao'>
            <input type='hidden' name='qtdeCarros' value='<?php echo $qtdeCarros; ?>'>
            <div class="grid">

                <?php
                for ($i = 1; $i <= $qtdeCarros; $i++) {
                    echo '<div class="grid_element">';
                    echo "<h3>Carro {$i}</h3>";
                    echo "<label>Modelo:</label><br>";
                    echo "<input type='text' name='modelo_{$i}' required><br>";
                    echo "<label>Cor:</label><br>";
                    echo "<input type='text' name='cor_{$i}' required><br><br>";
                    echo '</div>';
                }
                ?>


            </div>
            <button type='submit' class="proximo">Fabricar</button>
        </form>
    </div>
    <footer></footer>
</body>

</html>