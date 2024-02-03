<?php
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../login.php');
}else{
    if($_SESSION['rol'] != 3){
        header('location: ../login.php');
    }
}

$id = $_GET['id'];
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
    <?php
    include_once '../database.php';
        
        $db = new Database();
        $sql = "SELECT * FROM notificaciones WHERE id = :id AND idUsuario = :idUsuario ";
        $query = $db->connect()->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":idUsuario", $_SESSION['id']);
        $query->execute();
        
        $resultado = $query->fetchAll();
        
        $total  = 0;
        echo "<div class='detalles' >";
        foreach($resultado as $row){
            echo "<h1>Detalles del pedido</h1>";
            echo "<p>Numero de pedido: </p>";
            echo "<label>".$row['id']."</label>";
            echo "<br>";
            echo "<p>Fecha de pedido: </p>";
            echo "<label>".$row['fechaPublicacion']."</label>";
            echo "<br>";
            echo "<p>Descripcion de pedido: </p>";
            $cadena = rtrim($row['descripcion'], ',');//elimina la ultima coma
            $elementos = explode(',', $cadena);//divide la cadena por cada coma
            $items = array_chunk($elementos, 6);//mete en arreglos de arreglos 
            foreach($items as $item){
                $total += $item[5];
            }
            echo "<label>Total: ".$total."</label>";
            foreach($items as $item){
                echo "<div class='fila'>";
                    echo "<div class='imagen'></div>";
                        echo "<img src=".$item[3]." width='100' />";
                    echo "</div>";
                    echo "<div class='info'>";   
                        echo "<div class='nombre'>".$item[1]."</div>";
                        echo "<div>".$item[4]." items de $".$item[2]."</div>";
                        echo "<div>Subtotal: $".$item[5]."</div>";
                    echo "</div>";
                echo "</div>";
            }
            echo "<br>";
            echo "<p>Nombre del cliente: </p>";
            echo "<label>".$row['nombre']."</label>";
            echo "<br>";
        }
        echo "</div>";
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






