<?php

    session_start();

    if(!isset($_SESSION['rol'])){
        header('location: ../login.php');
    }else{
        if($_SESSION['rol'] != 1){
           header('location: ../login.php');
        }
    }
    
    date_default_timezone_set('America/Mexico_City');
    $hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>

    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Fondo de la pagina OSWALD-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">-->

    <!--Referencia del archivo CSS-->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../slider.css">
    <link rel="stylesheet" href="../tablas.css">
    <link rel="stylesheet" href="../botones.css">
<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <div class="contenedor">
        <nav class="nav-main">
            <img src="../img/logo cafeteria.png" alt="TechNews LOGO" class="nav-brand">
            <ul class="nav-menu">
                <form action="gerente.php">
                  <button type="submit" class="boton-regresar">Regresar</button>
                </form>
            </ul>
        </nav>
        <hr>
        
        <h1>Inventario de Ingredientes a Caducar</h1>
        <label>Fecha de Hoy</label>
        <?php
        echo "<label>$hoy</label>";
        include_once('../database.php');
        $db = new Database();
        $treintaDiasAntes = date("Y-m-d", strtotime($hoy . "-30 day"));
        $tresDiasDespues = date("Y-m-d", strtotime($hoy . "+3 day"));
        
        $sql = "SELECT * FROM ingrediente WHERE (fechacaducidad <= :hoy OR fechacaducidad BETWEEN :treintaDiasAntes AND :tresDiasDespues) OR  (cantidad <= '10')";
        $query = $db->connect()->prepare($sql);
        $query->bindParam(":hoy", $hoy);
        $query->bindParam(":treintaDiasAntes", $treintaDiasAntes);
        $query->bindParam(":tresDiasDespues", $tresDiasDespues);
        $query->execute();
        
        $resultado = $query->fetchAll();
        echo "<div style='width: 100%; overflow-x: scroll;'>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Fecha de Caducidad</th><th>Cantidad</th></tr>";
        foreach ($resultado as $fila) {
            echo "<tr>";
            echo "<td>" . $fila['id'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['fechaCaducidad'] . "</td>";
            echo "<td>" . $fila['cantidad'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        ?>
        <section class="social">
            <p>Follow Cafeteria Mineral del Monte</p>
            <div class="links">
                <a href="https://www.facebook.com/profile.php?id=100084863531303">
                    <i class="fab fa-facebook"></i>
                </a>
                <!--<a href="$">-->
                <!--    <i class="fab fa-twitter"></i>-->
                <!--</a>-->
                <!--<a href="$">-->
                <!--    <i class="fab fa-linkedin"></i>-->
                <!--</a>-->
            </div>
        </section>
    </div>
    <div class="footer-links">
        <div class="footer-container">
            <ul>
                <li>
                    <h3>Acerca de Nosotros</h3>
                </li>
                <li>
                    <p>Si la pagina tuvo algun error reportarlo a la pagina de facebook, o sino directamente al numero de telefono por medio de Whatsapp al: 33 3333 3333</p>
                </li>
            </ul>
        </div>
    </div>
    <footer class="footer">
        <h3>Cafeteria Mineral Del Monte</h3>
    </footer>
    <script src="../main1.js"></script>
    <script src="../slider.js"></script>
    <script src="../main_celular.js"></script>
</body>
</html>