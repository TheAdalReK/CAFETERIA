<?php
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../login.php');
}else{
    if($_SESSION['rol'] != 3){
        header('location: ../login.php');
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    
    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="css/main_notificacion.css">
    <link rel="stylesheet" href="../tablas.css">
    <link rel="stylesheet" href="../botones.css">
</head>
<body>
    <nav class="nav-main">
        <img src="../img/logo cafeteria.png" alt="LOGO" class="nav-brand">
        <form action="usuario.php">
          <button type="submit" class="boton-regresar">Regresar</button>
        </form>
    </nav>
    <hr>
    <h1>Mis Pedidos</h1>
    <?php
    include_once '../database.php';
    
        $db = new Database();
        $sql = "SELECT * FROM notificaciones WHERE idUsuario = :id AND estado = 2 AND idEmpleado IS NOT NULL ORDER BY id DESC";
        $query = $db->connect()->prepare($sql);
        $query->bindParam(":id", $_SESSION['id']);
        $query->execute();
        
        $resultado = $query->fetchAll();
        
        echo "<div class='fila'>";
                echo"<div style='width: 100%; overflow-x: scroll;'>";
                    echo "<table>";
                        echo "<tr><th>Numero de pedido</th><th>fecha de Pedido</th><th>Nombre</th><th>Estado del Pedido</th><th>Ver Pedidos</th></tr>";
                        foreach($resultado as $row){
                            echo"<tr>";
                            echo"<td>".$row['id']."</td>";
                            echo"<td>".$row['fechaPublicacion']."</td>";
                            echo"<td>".$row['nombre']."</td>";
                            echo"<td>Entregado</td>";
                            echo "<td><a href='abrirPedido.php?id={$row['id']}'>Abrir Pedido</a></td>";
                            echo"</tr>";
                        }
                echo"</table>";
            echo"</div>";
        echo"</div>";
    ?>
<div class="contenedor">
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
</body>
</html>

