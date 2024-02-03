<?php
    include_once 'database.php';
    session_start();
    $band = 0;
    $vacios = false;
    if(isset($_GET['cerrar_sesion'])){
        session_unset();
            
        session_destroy();
    }
            
    if(isset($_SESSION['rol'])){
        switch($_SESSION['rol']){
            case 1:
                header('location: /Gerente/gerente.php');
            break;
            case 2:
                header('location: /Empleado/empleado.php');
            break;
            case 3:
            header('location: /Usuario/usuario.php');
            break;
            
            default:
        }
    }
            
    if(isset($_POST['nombreUsuario_login']) && isset($_POST['password_login'])){
        $nombreUsuario_login = $_POST['nombreUsuario_login'];
        $password = md5($_POST['password_login']);
        if($nombreUsuario_login && $password){
            $db = new Database();
            $query = $db->connect()->prepare('SELECT*FROM usuarios WHERE nombreUsuario = :nombreUsuario_login AND password = :password_login');
            $query->execute(['nombreUsuario_login' => $nombreUsuario_login, 'password_login' => $password]);
                
            $row = $query->fetch(PDO::FETCH_NUM);
            if($row == true){
                // validar rol
                $id = $row[0];
                $_SESSION['id'] = $id;
                $nombre = $row[1];
                $_SESSION['nombre'] = $nombre;
                $rol = $row[9];
                $_SESSION['rol'] = $rol;
                
                switch($_SESSION['rol']){
                    case 1:
                        header('location: /Gerente/gerente.php');
                    break;
                    case 2:
                        header('location: /Empleado/empleado.php');
                    break;
                    case 3:
                        header('location: /Usuario/usuario.php');
                    break;
                    default:
                }
            }else{
                $band = 1;
            }
        }else
            $vacios = true;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Cafeteria del Monte: Login</title>
</head>

<body>
    <button id="regresar-btn" >&larr; Regresar</button>
    <div class="container-form sign-up">
        <div class="welcome-back">
            <div class="message">
                <h2>Bienvenido a Cafeteria del Monte</h2>
                <p>Si ya tienes una cuenta por favor inicia sesion aqui</p>
                <button class="sign-up-btn">Iniciar Sesion</button>
            </div>
        </div>
        <form action="#" method="POST"  class="formulario">
            <h2 class="create-account">Crear una cuenta</h2>
            <div class="iconos">
                <!--<div class="border-icon">-->
                <!--    <i class='bx bxl-instagram'></i>-->
                <!--</div>-->
                <!--<div class="border-icon">-->
                <!--    <i class='bx bxl-linkedin' ></i>-->
                <!--</div>-->
                <div class="border-icon">
                    <a href="https://www.facebook.com/profile.php?id=100084863531303">
                        <i class='bx bxl-facebook-circle' ></i>
                    </a>
                </div>
            </div>
            <p class="cuenta-gratis">Crear una cuenta gratis</p>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="nombreUsuario" placeholder="Nombre de usuario" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Contraseña" minlength="6" maxlength="18" required>
            <input type="submit" value="Registrarse">
            <?php
                include_once 'database.php';
                
                if(isset($_POST['nombre']) && isset($_POST['nombreUsuario']) && isset($_POST['email']) && isset($_POST['password'])){
                    $nombre = $_POST['nombre'] ;
                    $email = $_POST['email'];
                    $nombreusuario = $_POST['nombreUsuario'];
                    $password = md5($_POST['password']);
                    
                    
                        
                    if($nombre && $email && $nombreusuario && $password){
                        
                        $db = new Database();
                        $query = $db->connect()->prepare('SELECT COUNT(*) as count FROM usuarios WHERE nombreUsuario = :nombreUsuario');
                        $query->execute(['nombreUsuario' => $nombreusuario]);
                            
                        $row = $query->fetch(PDO::FETCH_ASSOC);
                        
                        if($row['count'] > 0){
                            echo "El nombre de Usuario ya existe, coloca otro nuevamente";
                        }else{
                            $status = 0;
                            $idRol = 3;
                             $activationcode=md5($email.time());
                            
                            $db = new Database();
                            $sql = "INSERT INTO usuarios (nombre, email, nombreUsuario, password,activationcode, status, idRol) VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $query = $db->connect()->prepare($sql);
                                    
                            $query->bindParam(1, $nombre);
                            $query->bindParam(2, $email);
                            $query->bindParam(3, $nombreusuario);
                            $query->bindParam(4, $password);
                            $query->bindParam(5, $activationcode);
                            $query->bindParam(6, $status);
                            $query->bindParam(7, $idRol);
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
                                echo "Registro completado, por favor verifique en el ID de correo electrónico registrado";
                            } else {
                                echo "No se pudo";
                            }
                        }
                    
                    }else{
                        echo "Campos vacios";
                    }
                    
                }
            ?>
        </form>
    </div>
    <div class="container-form sign-in">
        <form id="formulario" method="POST" class="formulario">
            <h2 class="create-account">Iniciar Sesion</h2>
            <div class="iconos">
                <!--<div class="border-icon">-->
                <!--    <i class='bx bxl-instagram'></i>-->
                <!--</div>-->
                <!--<div class="border-icon">-->
                <!--    <i class='bx bxl-linkedin' ></i>-->
                <!--</div>-->
                <div class="border-icon">
                    <a href="https://www.facebook.com/profile.php?id=100084863531303">
                        <i class='bx bxl-facebook-circle' ></i>
                    </a>
                </div>
            </div>
            <p class="cuenta-gratis">¿Aun no tienes una cuenta?</p>
            <input type="text" name="nombreUsuario_login" placeholder="nombre de usuario" required>
            <input type="password" name="password_login" placeholder="contraseña" required>
            <input type="submit"  value="Iniciar Sesion">
            <?php
                if($vacios){
                    echo "Los campos estan vacios";
                    $vacios = false;
                }else{
                    if($band==1){
                        echo "El usuario o contraseña son incorrectos";
                        $band = 0;
                    }
                }
            ?>
        </form>
        <div class="welcome-back">
            <div class="message">
                <h2>Bienvenido de nuevo</h2>
                <p>Si aun no tienes una cuenta por favor registrese aqui</p>
                <button class="sign-in-btn">Registrarse</button>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
</body>

</html>