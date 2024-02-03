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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="slider.css">
    
    <!--Menu responsive---------------->
  <link rel="stylesheet" href="estilos.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!------------------------------------->
   <style>
    .container-box{
      width: "100%",
      height: "100%",
      position: relative;
       padding: 30px;
    }
   </style>
</head>
<body>
      
    <header>
      <h1><img src="img/logo cafeteria.png" alt="LOGO" class="nav-brand"></h1>
    </header>
    
    <nav>
          <ul>
            <li><a href="bebidascalientes.php">Realizar Pedido</a></li>
            <li><a href="login.php">Acceder</a></li>
          </ul>
          <div class="hide">
            <i class="fa fa-bars" aria-hidden="true"></i> Menu
          </div>
    </nav>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(".hide").on('click', function() {
        $("nav ul").toggle('slow');
        })
    </script>
    

<div class="contenedor">
    <div class="container-box" >
        <div>
        <img  src="./img/comb_1.jpg"  width="100%" height="100%">
        </div>
    </div>
     
    <!-- Productos CARDS -->
    
    <div class="productos-cards">
        <!--Slider de imagenes-->
        <div class="slide-contenedor">
                <h3>Platillos del Día</h3>
                <div class="miSlider fade">
                    <img src="./img/cafe.jpg" alt="" >
                </div>
                <div class="miSlider fade">
                    <img src="./img/sandwich.jpeg" alt="">
                </div>
                <div class="miSlider fade">
                    <img src="./img/croissant.jpg" alt="">
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
        <div>
            <h3>Ubicacion</h3>
            <iframe class="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.8923951664506!2d-103.28855662018091!3d20.673956331609194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b1b6ccc28377%3A0x562882ed9d14797!2sCafeteria%20Mineral%20Del%20Monte!5e0!3m2!1ses!2smx!4v1681596970202!5m2!1ses!2smx" width="100%" height="35%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                <!--    <i class="fab fa-instagram"></i>-->
                <!--</a>-->
            </div>
        </section>
</div>

    <footer class="footer">
        <h3>Cafeteria Mineral Del Monte</h3>
    </footer>
    <script src="main1.js"></script>
    <script src="slider.js"></script>
</body>
</html>