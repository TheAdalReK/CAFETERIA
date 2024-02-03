<?php
    include_once '../database.php';
    session_start();

    if(!isset($_SESSION['rol'])){
        header('location: ../login.php');
    }else{
        if($_SESSION['rol'] != 1){
           header('location: ../login.php');
        }
    }
    
    $idEmpleado = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>

    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Fondo de la pagina OSWALD-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">-->

    <!--Referencia del archivo CSS-->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../slider.css">
    <link rel="stylesheet" href="../tablas.css">
    <link rel="stylesheet" href="../botones.css">
</head>
<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <div class="contenedor">
        <nav class="nav-main">
            <img src="../img/logo cafeteria.png" alt="LOGO" class="nav-brand">
            <ul class="nav-menu">
                <form action="agregarempleado.php">
                  <button type="submit" class="boton-regresar">Regresar</button>
                </form>
            </ul>
        </nav>
        <hr>
        <div>
            <form action="editarEmpleado.php?id=<?php echo $idEmpleado ?>" method="POST" >
                <?php
                    
                    $db = new Database();
                    $sql = "SELECT * FROM usuarios WHERE id = :idEmpleado";
                    $query = $db->connect()->prepare($sql);
                    $query->execute([':idEmpleado' => $idEmpleado]);
                    
                    while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<label>Codigo</label>";
                        echo "<input type='numeric' name='id' value=".$fila['id']." disabled>";
                        echo "<br>";
                        echo "<label>Nombre</label>";
                        echo "<input type='text' name='nombre' value='".$fila['nombre']."'>";
                        echo "<br>";
                        echo "<label>Apellido</label>";
                        echo "<input type='text' name='apellido' value='".$fila['apellido']."'>";
                        echo "<br>";
                        echo "<label>Correo</label>";
                        echo "<input type='email' name='email' value=".$fila['email'].">";
                        echo "<br>";
                        echo "<label>Edad</label>";
                        echo "<input type='numeric' name='edad' value=".$fila['edad'].">";
                        echo "<br>";
                        echo "<label>Nombre de Usuario</label>";
                        echo "<input type='text' name='nombreUsuario' value=".$fila['nombreUsuario'].">";
                        echo "<br>";
                        echo "<label>Rol</label>";
                        echo "<input type='numeric' name='idRol' value=".$fila['idRol'].">";
                        echo "<br>";
                    }
                ?>
                <input type="submit" value="Actualizar Empleado">
                <input type="button" value="Refrescar" class="boton-refrescar" onclick="location.reload()">
            </form>
        </div>
        <div>
            <?php
                if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['edad']) && isset($_POST['nombreUsuario']) && isset($_POST['idRol'])){
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $email = $_POST['email'];
                    $edad = $_POST['edad'];
                    $nombreUsuario = $_POST['nombreUsuario'];
                    $idrol = $_POST['idRol'];
                    
                    if($nombre && $apellido && $email && $edad && $nombreUsuario && $idrol){
                        
                        $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido,  email = :email, edad = :edad, nombreUsuario = :nombreUsuario, idRol = :idrol WHERE id = :idEmpleado";
                        $query = $db->connect()->prepare($sql);
                        
                        $query->bindParam(":nombre", $nombre);
                        $query->bindParam(":apellido", $apellido);
                        $query->bindParam(":email", $email);
                        $query->bindParam(":edad", $edad);
                        $query->bindParam(":nombreUsuario", $nombreUsuario);
                        $query->bindParam(":idrol", $idrol);
                        $query->bindParam(":idEmpleado", $idEmpleado);
                        
                        if($query->execute())
                            echo "<label>Empleado actualizado</label>";
                        
                    }else{
                        echo "<label>Campos vacios</label>";
                    }
                }
                
            ?>
        </div>
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