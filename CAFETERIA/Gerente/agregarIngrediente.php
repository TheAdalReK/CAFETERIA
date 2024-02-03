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
    <title>Agregar Ingredientes</title>

    <!-- Fondo de las letras AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Fondo de la pagina OSWALD-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">-->

    <!--Referencia del archivo CSS-->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../slider.css">
    <link rel="stylesheet" href="../tablas.css">
    <link rel="stylesheet" href="../botones.css">
    
    <script>
        function mostrarRecuadro(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este ingrediente?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        location.reload();
                    }
                };
                xhr.open("POST", "eliminarIngrediente.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + id);
            }
        }
    </script>
</head>
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
            <h1>Agregar Ingrediente</h1>
            <form action="agregaringrediente.php" method="POST">
                <input type="text" name="nombre" placeholder="nombre">
                <input type="date" name="fechaCaducidad">
                <input type="numeric" name="cantidad" placeholder="cantidad">
                <input type="submit" value="Añadir Ingrediente">
            </form>
        </div>
        <div id="todolist">
            <?php
                include_once '../database.php';
                
                if(isset($_POST['nombre']) && isset($_POST['fechaCaducidad']) && isset($_POST['cantidad'])){
                    $nombre = $_POST['nombre'];
                    $fecha = $_POST['fechaCaducidad'];
                    $cantidad = $_POST['cantidad'];
                    
                    if($nombre && $fecha && $cantidad){
                        $db = new Database();
                        $sql = "INSERT INTO ingrediente (nombre, fechaCaducidad, cantidad) VALUES (?, ?, ?)";
                        $query = $db->connect()->prepare($sql);
                                
                        $query->bindParam(1, $nombre);
                        $query->bindParam(2, $fecha);
                        $query->bindParam(3, $cantidad);
                        $query->execute();
                        
                        if ($query->rowCount() > 0) {
                            echo "<label>ingrediente agregado correctamente</label>";
                        } else {
                            echo "<label>no se pudo agregar el ingrediente</label>";
                        }
                    }else{
                        echo "<label>Campos vacios</label>";
                    }
                }
            ?>
        </div>
        <div>
            <h2>Ingredientes</h2>
            <?php
                include_once '../database.php';
                
                $db = new Database();
                $sql = "SELECT * FROM ingrediente";
                $query = $db->connect()->prepare($sql);
                $query->execute();
                
                $resultado = $query->fetchAll();
                echo "<div style='width: 100%; overflow-x: scroll;'>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Fecha de Caducidad</th><th>Cantidad</th><th>Editar</th><th>Eliminar</th></tr>";
                foreach ($resultado as $fila) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['fechaCaducidad'] . "</td>";
                    echo "<td>" . $fila['cantidad'] . "</td>";
                    echo '<td><button class="boton-refrescar"><a href="editarIngrediente.php?id='.$fila['id'].'" type="button">Editar</a></button></td>';
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