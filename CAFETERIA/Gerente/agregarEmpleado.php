<?php

    session_start();

    if(!isset($_SESSION['rol'])){
        header('location: ../login.php');
    }else{
        if($_SESSION['rol'] != 1){
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
    <title>Agregar Empleado</title>

    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Fondo de la pagina OSWALD-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">-->

    <!--Referencia del archivo CSS-->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../slider.css">
    <link rel="stylesheet" href="../tablas.css">
    <!--<link rel="stylesheet" href="../main_celular.css">-->
    <link rel="stylesheet" href="../botones.css">
    <script>
        function mostrarRecuadro(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este Empleado?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        location.reload();
                    }
                };
                xhr.open("POST", "eliminarEmpleado.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + id);
            }
        }
    </script>
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
        <div>
            <h1>Agregar Empleado</h1>
            <form action="agregarempleado.php" method="POST">
                <input type="text" name="nombre" placeholder="nombre">
                <input type="text" name="apellido" placeholder="apellido">
                <input type="email" name="email" placeholder="correo">
                <input type="text" name="nombreUsuario" placeholder="nombre de usuario">
                <input type="password" name="password" placeholder="contraseña">
                <input type="numeric" name="edad" placeholder="edad">
                <input type="submit" value="Añadir empleado">
            </form>
        </div>
        <div id="todolist">
            <?php
                include_once '../database.php';
                
                if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['edad']) && isset($_POST['nombreUsuario']) && isset($_POST['password'])){
                    $nombre = $_POST['nombre'] ;
                    $apellido = $_POST['apellido'];
                    $email = $_POST['email'];
                    $edad = $_POST['edad'];
                    $nombreusuario = $_POST['nombreUsuario'];
                    $password = md5($_POST['password']);
                    // $activationcode = 1;
                    // $status = 0;
                    // $idRol = 2;
                    
                    if($nombre && $apellido && $email && $edad && $nombreusuario && $password ){
                        $db = new Database();
                        $query = $db->connect()->prepare('SELECT COUNT(*) as count FROM usuarios WHERE nombreUsuario = :nombreUsuario');
                        $query->execute(['nombreUsuario' => $nombreusuario]);
                            
                        $row = $query->fetch(PDO::FETCH_ASSOC);
                        
                        if($row['count'] > 0){
                            echo "<label>El nombre de Usuario ya existe, coloca otro nuevamente</label>";
                        }else{
                            $status = 0;
                            $idRol = 2;
                            $activationcode=md5($email.time());
                            $db = new Database();
                            $sql = "INSERT INTO usuarios (nombre, apellido, email, edad, nombreUsuario, password,activationcode, status, idRol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $query = $db->connect()->prepare($sql);
                                    
                            $query->bindParam(1, $nombre);
                            $query->bindParam(2, $apellido);
                            $query->bindParam(3, $email);
                            $query->bindParam(4, $edad);
                            $query->bindParam(5, $nombreusuario);
                            $query->bindParam(6, $password);
                            $query->bindParam(7, $activationcode);
                            $query->bindParam(8, $status);
                            $query->bindParam(9, $idRol);
                            $query->execute();
                            
                            if ($query->rowCount() > 0) {
                                $to=$email;
                                $msg= "Gracias por registrarte.";
                                $subject="Email de verificación de Cafeteria Mineral Del Monte";
                                $headers = "MIME-Version: 1.0"."\r\n";
                                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                                $headers .= 'From:Cafeteria Mineral Del Monte | Verificacion de cuenta <cafeteriamineraldelmonte@gmail.com>'."\r\n";
                                $ms="<html></body><div><div>Dear $nombre,</div></br></br>";
                                $ms.="<div style='padding-top:8px;'>Please click The following link For verifying and activation of your account</div>
                                <div style='padding-top:10px;'><a href='https://cafeteriamineral.000webhostapp.com/email_verificacion.php?code=$activationcode'>Click Here</a></div>
                                </body></html>";
                                mail($to,$subject,$ms,$headers);
                                echo "<label> Registro compleatdo, por favor verifique en el ID de correo electrónico registrado</label>";
                            } else {
                                echo "<label>no se pudo agregar el Empleado</label>";
                            }
                        }
                    }else{
                        echo "<label>Campos Vacios</label>";
                    }
                }
            ?>
        </div>
        <div>
            <h2>Empleados</h2>
            <?php
                include_once '../database.php';
                
                
                $db = new Database();
                $sql = "SELECT * FROM usuarios WHERE idRol=2 ";
                $query = $db->connect()->prepare($sql);
                $query->execute();
                
                $resultado = $query->fetchAll();
                echo "<div style='width: 100%; overflow-x: scroll;'>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Edad</th><th>Nombre de usuario</th><th>Editar</th><th>Eliminar</th></tr>";
                foreach ($resultado as $fila) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['apellido'] . "</td>";
                    echo "<td>" . $fila['email'] . "</td>";
                    echo "<td>" . $fila['edad'] . "</td>";
                    echo "<td>" . $fila['nombreUsuario'] . "</td>";
                    echo '<td><button class="boton-refrescar"><a href="editarEmpleado.php?id='.$fila['id'].'" type="button">Editar</a></button></td>';
                    echo '<td><button class="boton-refrescar" onclick="mostrarRecuadro('.$fila['id'].')">Eliminar</button></td>';
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
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