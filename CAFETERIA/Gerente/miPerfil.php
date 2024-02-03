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
    <title>Mi Perfil</title>

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
        
        <h1>Mi Perfil</h1>
        <label>Fecha de Hoy</label>
        <?php
        echo "<label>$hoy</label>";
        include_once('../database.php');
        $db = new Database();
        
        
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $query = $db->connect()->prepare($sql);
        $query->bindParam(":id", $_SESSION['id']);
        $query->execute();
        
        $resultado = $query->fetchAll();
        
        echo "<form method='post' >";
        echo "<div style='width: 100%; overflow-x: scroll;'>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Edad</th><th>Nombre De Usuario</th></tr>";
        foreach ($resultado as $fila) {
            echo "<tr>";
            echo "<td><input type='text' name='nombre' value=".$fila['nombre']."></td>";
            echo "<td><input type='text' name='apellido' value=".$fila['apellido']."></td>";
            echo "<td><input type='email' name='email' value=".$fila['email']."></td>";
            echo "<td><input type='numeric' name='edad' value=".$fila['edad']."></td>";
            echo "<td><input type='text' name='nombreUsuario' value=".$fila['nombreUsuario']."></td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
            <input type="submit" value="Actualizar">
            <input type="button" value="Refrescar" class="boton-refrescar" onclick="location.reload()">
        </div>
        </form>
        <?php
        if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['nombreUsuario']) && isset($_POST['email'])  && isset($_POST['edad']) ){
            $nombre = $_POST['nombre'] ;
            $email = $_POST['email'];
            $nombreusuario = $_POST['nombreUsuario'];
            $apellido = $_POST['apellido'];
            $edad = $_POST['edad'];
            
            
                
            if($nombre && $apellido && $email && $nombreusuario && $edad  ){
                
                $db = new Database();
                $query = $db->connect()->prepare('SELECT COUNT(*) as count, id FROM usuarios WHERE nombreUsuario = :nombreUsuario');
                $query->execute(['nombreUsuario' => $nombreusuario]);
                    
                $row = $query->fetch(PDO::FETCH_ASSOC);
                if(( $row['count'] > 0) && ($row['id'] != $_SESSION['id'])){
                        echo "<label>El nombre de Usuario ya existe, coloca otro nuevamente</label>";
                }else{
                    
                    $db = new Database();
                    $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido,  email = :email, edad = :edad, nombreUsuario = :nombreUsuario  WHERE id = :id";
                    $query = $db->connect()->prepare($sql);
                    
                    $query->bindParam(":nombre", $nombre);
                    $query->bindParam(":apellido", $apellido);
                    $query->bindParam(":email", $email);
                    $query->bindParam(":edad", $edad);
                    $query->bindParam(":nombreUsuario", $nombreusuario);
                    $query->bindParam(":id", $_SESSION['id']);
                    
                    if($query->execute()){
                        echo "<label>Perfil Actualizado</label>";
                    } else {
                        echo "<label>No se pudo</label>";
                    }
                }
            
            }else{
                echo "<label>Campos vacios</label>";
            }
                    
        }
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
    <script src="../main.js"></script>
    <script src="../slider.js"></script>
    <script src="../main_celular.js"></script>
</body>
</html>