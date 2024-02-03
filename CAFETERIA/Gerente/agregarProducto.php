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
    <title>Agregar Producto</title>

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
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        location.reload();
                    }
                };
                xhr.open("POST", "eliminarProducto.php", true);
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
            <h1>Agregar Producto</h1>
            <form action="agregarproducto.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="nombre">
                <br>
                <input type="text" name="descripcion" placeholder="descripcion">
                <br>
                <input type="numeric" name="gramos" placeholder="gramos">
                <br>
                <input type="numeric" name="precio" placeholder="precio">
                <br>
                <input type="numeric" name="cantidad" placeholder="cantidad">
                <br>
                <input type="file" name="imagen">
                <br>
                <p>
                    <?php
                        $categoria = "";
                    ?>
        			Categoria: <br>	
        			<select name="categoria">
        				<option value="">Selecciona una categoria</option>
        				<option value="bebidacaliente" <?php if($categoria == "bebidacaliente") echo "selected" ?> > Bebidas Calientes</option>
        				<option value="especialidad" <?php if($categoria == "especialidad") echo "selected" ?> >Especialidad</option>
        				<option value="bebidasfrias" <?php if($categoria == "bebidasfrias") echo "selected" ?> >Bebidas Frias</option>
        				<option value="alimentos" <?php if($categoria == "alimentos") echo "selected" ?> >Alimentos</option>
        			</select>
        		</p>
                <h2>Ingredientes</h2>
                <h3>Selecciona los ingredientes</h3>
                <?php
                    include_once '../database.php';
                    
                    $db = new Database();
                    $sql = "SELECT id, nombre FROM ingrediente";
                    $query = $db->connect()->prepare($sql);
                    $query->execute();
                    
                    $resultado = $query->fetchAll();
                    $suma = 1;
                    echo "<table>";
                    echo "<tr><th>Nombre</th><th>Seleccionar</th></tr>";
                    foreach ($resultado as $fila) {
                        echo "<label>";
                            echo "<tr>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo '<td><input type="checkbox" name="ingrediente'.$suma.'" value='.$fila['id'].'></td>';
                            echo "</tr>";
                        echo "</label>";
                        $suma++;
                    }
                    echo "</table>";
                ?>
                <input type="submit" value="Añadir producto">
            </form>
        </div>
        <div id="todolist">
            <div>
                <?php
                    include_once '../database.php';
                    
                    if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['gramos']) && isset($_POST['precio']) && isset($_POST['cantidad']) && isset($_POST['categoria'])){
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion'];
                        $gramos = $_POST['gramos'];
                        $precio = $_POST['precio'];
                        $cantidad = $_POST['cantidad'];
                        $categoria = $_POST['categoria'];
                        
                        $nombre_imagen = $_FILES['imagen']['name'];
                        
                        
                        //Genera todos los varoles de nuestros ingredientes y comprueba que exista valor
                        $i = 1;
                        $j = 0;
                        while($i < $suma){
                            if(isset($_POST['ingrediente'.$i.''])){
                                $idIngrediente[$j] = $_POST["ingrediente$i"];
                                $j++;
                            }
                            $i++;
                        }
                        
                        $idProducto = 1;
                        if($nombre && $descripcion && $gramos && $precio && $cantidad && $idIngrediente[0] && $idProducto && $nombre_imagen && $categoria){
                            
                            $temporal = $_FILES['imagen']['tmp_name'];
                            $carpeta = '../img';//ruta
                            $ruta = $carpeta.'/'.$nombre_imagen;
                            move_uploaded_file($temporal,$carpeta.'/'. $nombre_imagen);
                            
                            $db = new Database();
                            $sql = "INSERT INTO producto (nombre, descripcion, gramos, precio, cantidad, imagen, categoria) VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $query = $db->connect()->prepare($sql);
                                    
                            $query->bindParam(1, $nombre);
                            $query->bindParam(2, $descripcion);
                            $query->bindParam(3, $gramos);
                            $query->bindParam(4, $precio);
                            $query->bindParam(5, $cantidad);
                            $query->bindParam(6, $ruta);
                            $query->bindParam(7, $categoria);
                            $query->execute();
                            
                            $sqlP = "SELECT id FROM producto";
                            $queryPro = $db->connect()->prepare($sqlP);
                            $queryPro->execute();
                            
                            $resultado = $queryPro->fetchAll();
                            
                            foreach ($resultado as $fila)
                                $idProducto = $fila['id'];
                            
                            //consulta iterable 
                            $k = 0;
                            while($k < $j){
                                $sqlPI = "INSERT INTO productoIngrediente (idProducto,idIngrediente) VALUES (?,?)";
                                $queryIng = $db->connect()->prepare($sqlPI);
                                        
                                $queryIng->bindParam(1, $idProducto);
                                $queryIng->bindParam(2, $idIngrediente[$k]);
                                $queryIng->execute();
                                $k++;
                            }
                            
                            if (($queryIng->rowCount() > 0) && ($query->rowCount() > 0)) {
                                echo "<label>producto e ingrediente agregado correctamente</label>";
                            } else {
                                echo "<label>no se pudo agregar el producto e ingredientes</label>";
                            }
                        }else{
                            echo "<label>Campos vacios</label>";
                        }
                    }
                ?>
            </div>
            <h4>Productos</h4>
            <div>
                <?php
                    $categoria_nombre = ['bedidascalientes','especialidad','bebidasfrias','alimentos'];
                    $categoria_nombre_sec = ['Bedidas Calientes','Especialidad','Bebidas Frias','Alimentos'];
                    $numero_categoria = 0;
                    
                    $db = new Database();
                    $sql = "SELECT * FROM producto";
                    $query = $db->connect()->prepare($sql);
                    $query->execute();
                    
                    $resultado = $query->fetchAll();
                    echo "<div style='width: 100%; overflow-x: scroll;'>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Nombre</th><th>Descripcion</th><th>Gramos</th><th>Precio</th><th>Cantidad</th><th>Imagen</th><th>Categoria</th><th>Editar</th><th>Eliminar</th></tr>";
                    foreach ($resultado as $fila) {
                        echo "<tr>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['descripcion'] . "</td>";
                        echo "<td>" . $fila['gramos'] . "</td>";
                        echo "<td>$" . $fila['precio'] . "</td>";
                        echo "<td>" . $fila['cantidad'] . "</td>";
                        echo '<td><img src="'.$fila['imagen'].'" width="80" style="border-radius: 50%"></td>';
                        for($i=0; $i<4; $i++){
                            if($fila['categoria'] == $categoria_nombre[$i]){
                                $numero_categoria = $i;
                                break;
                                
                            }
                        }
                        echo "<td>" . $categoria_nombre_sec[$numero_categoria] . "</td>";
                        echo '<td><button class="boton-refrescar"><a href="editarProducto.php?id='.$fila['id'].'" type="button">Editar</a></button></td>';
                        echo '<td><button class="boton-refrescar" onclick="mostrarRecuadro('.$fila['id'].')">Eliminar</button></td>';
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                ?>
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
    <script src="../main1.js"></script>
    <script src="../slider.js"></script>
    <script src="../main_celular.js"></script>
</body>
</html>