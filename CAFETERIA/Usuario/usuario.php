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
    <title>Cafeteria del monte</title>

    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Fondo de la pagina OSWALD-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">-->

    <!--Referencia del archivo CSS-->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../slider.css">
    <link rel="stylesheet" href="css/main_notificacion.css">
    <link rel="stylesheet" href="../botones.css">
    <link rel="stylesheet" href="../tabla_notificacion.css">
</head>
<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <div class="contenedor">
        <nav class="nav-main">
            <img src="../img/logo cafeteria.png" alt="LOGO" class="nav-brand">
            <ul class="nav-menu">
            <!--Cambiar pedidos solo para usuario(gerente y empleado)-->
                <li>
                    <a href="misPedidos.php">Mis Pedidos</a>
                </li>
                <li> 
                    <a href="miPerfil.php">Mi Perfil</a>
                </li>
                <li>
                    <a href="bebidascalientes.php">Realizar pedido</a>
                </li>
                <!--<li>-->
                <!--    <a href="#">Quienes somos</a>-->
                <!--</li>-->
                <br>
                <li>
                    <form method="post" action="../cerrar_sesion.php">
                      <button type="submit" name="cerrar_sesion" class="boton-cerrar-sesion">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
            <ul>
                <li class="carrito">
                    <li class="carrito">
                        <a href="#" class='btn-carrito'>Notificaciones</a>
                        <div id="carrito-container">
                            <div id="tabla">
                            </div>
                        </div>
                    </li>
                </li>
            </ul>
        </nav>
        <hr>
        
        <!-- Productos CARDS -->
        <div class="productos-cards">
            <!--Slider de imagenes-->
            <div>
                <h3>Productos</h3>
                <img src="../img/cafe.jpg" alt="Productos">
                
            </div>
            <div class="productos2">
                <h3>Latte Frio</h3>
                <img src="../img/latte frio.png" alt="Productos">
            </div>
            <div class="slide-contenedor">
                <h3>Menu del Día</h3>
                <div class="miSlider fade">
                    <img src="../img/cafe.jpg" alt="">
                </div>
                <div class="miSlider fade">
                    <img src="../img/sandwich.jpeg" alt="">
                </div>
                <div class="miSlider fade">
                    <img src="../img/croissant.jpg" alt="">
                </div>
                <div class="direcciones">
                    <a href="#" class="atras" onclick="avanzaSlide(-1)">&#10094;</a>
                    <a href="#" class="adelante" onclick="avanzaSlide(1)">&#10095;</a>
                </div>
                <div class="barras">
                    <span class="barra active" onclick="posicionSlide(1)"></span>
                    <span class="barra" onclick="posicionSlide(2)"></span>
                    <span class="barra" onclick="posicionSlide(3)"></span>
                </div>
            </div>
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
    <script src="../main.js"></script>
    <script src="../main_celular.js"></script>
    <script src="../slider.js"></script>
    <script src="notificaciones.js"></script>
</body>
</html>
