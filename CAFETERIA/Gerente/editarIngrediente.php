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
    
    $idIngrediente = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>

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
            <img src="../img/logo cafeteria.png" alt="TechNews LOGO" class="nav-brand">
            <ul class="nav-menu">
                <form action="agregaringrediente.php">
                  <button type="submit" class="boton-regresar">Regresar</button>
                </form>
            </ul>
        </nav>
        <hr>
        <div>
            <form action="editarIngrediente.php?id=<?php echo $idIngrediente ?>" method="POST" >
                <?php
                    
                    $db = new Database();
                    $sql = "SELECT * FROM ingrediente WHERE id = :idIngrediente";
                    $query = $db->connect()->prepare($sql);
                    $query->execute([':idIngrediente' => $idIngrediente]);
                    
                    while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<label>Codigo</label>";
                        echo "<input type='numeric' name='id' value=".$fila['id']." disabled>";
                        echo "<br>";
                        echo "<label>Nombre</label>";
                        echo "<input type='text' name='nombre' value='".$fila['nombre']."'>";
                        echo "<br>";
                        echo "<label>Fecha de Caducidad</label>";
                        echo "<input type='date' name='fechaCaducidad' value=".$fila['fechaCaducidad'].">";
                        echo "<br>";
                        echo "<label>Cantidad</label>";
                        echo "<input type='numeric' name='cantidad' value=".$fila['cantidad'].">";
                        echo "<br>";
                    }
                ?>
                <input type="submit" value="Actualizar Ingrediente">
                <input type="button" class="boton-refrescar" value="Refrescar" onclick="location.reload()">
            </form>
        </div>
        <div>
            <?php
                if(isset($_POST['nombre']) && isset($_POST['fechaCaducidad']) && isset($_POST['cantidad'])){
                    $nombre = $_POST['nombre'];
                    $fechaCaducidad = $_POST['fechaCaducidad'];
                    $cantidad = $_POST['cantidad'];
                    
                    if($nombre && $cantidad && $fechaCaducidad){
                        
                        $sql = "UPDATE ingrediente SET nombre = :nombre, fechaCaducidad = :fechaCaducidad,  cantidad = :cantidad WHERE id = :idIngrediente";
                        $query = $db->connect()->prepare($sql);
                        
                        $query->bindParam(":nombre", $nombre);
                        $query->bindParam(":fechaCaducidad", $fechaCaducidad);
                        $query->bindParam(":cantidad", $cantidad);
                        $query->bindParam(":idIngrediente", $idIngrediente);
                        
                        if($query->execute())
                            echo "<label>Ingrediente actualizado</label>";
                        
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