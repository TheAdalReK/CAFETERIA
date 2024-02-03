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
    
    $idProducto = $_GET['id'];
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
                <form action="agregarproducto.php">
                  <button type="submit" class="boton-regresar">Regresar</button>
                </form>
            </ul>
        </nav>
        <hr>
        <div>
            <form action="editarProducto.php?id=<?php echo $idProducto ?>" method="POST" enctype="multipart/form-data">
                <?php
                    
                    $db = new Database();
                    $sql = "SELECT * FROM producto WHERE id = :idProducto";
                    $query = $db->connect()->prepare($sql);
                    $query->execute([':idProducto' => $idProducto]);
                    $resultado = $query->fetchAll();
                    foreach($resultado as $fila){
                        echo "<label>Codigo</label>";
                        echo "<input type='numeric' name='id' value=".$fila['id']." disabled>";
                        echo "<br>";
                        echo "<label>Nombre</label>";
                        echo "<input type='text' name='nombre' value='".$fila['nombre']."'>";
                        echo "<br>";
                        echo "<label>Descripcion</label>";
                        echo "<input type='text' name='descripcion' value='".$fila['descripcion']."'>";
                        echo "<br>";
                        echo "<label>Gramos</label>";
                        echo "<input type='numeric' name='gramos' value=".$fila['gramos'].">";
                        echo "<br>";
                        echo "<label>Precio</label>";
                        echo "<input type='numeric' name='precio' value=".$fila['precio'].">";
                        echo "<br>";
                        echo "<label>Cantidad</label>";
                        echo "<input type='numeric' name='cantidad' value=".$fila['cantidad'].">";
                        echo "<br>";
                        echo "<label>Imagen</label>";
                        echo "<br>";
                        echo '<img src="'.$fila['imagen'].'" width="80" style="border-radius: 50%">';
                        echo "<br>";
                        $ruta = $fila['imagen'];
                        echo "<input type='file' name='imagen'>";
                        echo "<br>";
                        echo "<p>";
                            $categoria = $fila['categoria']; // valor obtenido de la base de datos es la categoria actual
                            echo "Categoria: <br>";
                            echo "<select name='categoria'>";
                                echo "<option value=''>Selecciona una categoria</option>";
                                echo "<option value='bebidascalientes' " . ($categoria == 'bebidascalientes' ? 'selected' : '') . ">Bebidas Calientes</option>";
                                echo "<option value='especialidad' " . ($categoria == 'especialidad' ? 'selected' : '') . ">Especialidad</option>";
                                echo "<option value='bebidasfrias' " . ($categoria == 'bebidasfrias' ? 'selected' : '') . ">Bebidas Frias</option>";
                                echo "<option value='alimentos' " . ($categoria == 'alimentos' ? 'selected' : '') . ">Alimentos</option>";
                            echo "</select>";
                        echo "</p>";
                    }
                    
                    $sqlIng = "SELECT id, nombre FROM ingrediente";
                    $queryIng = $db->connect()->prepare($sqlIng);
                    $queryIng->execute();
                    
                    $resultadoIng = $queryIng->fetchAll();
                    
                    $sqlPI = "SELECT idIngrediente FROM productoIngrediente WHERE idProducto = :idProducto";
                    $queryPI = $db->connect()->prepare($sqlPI);
                    $queryPI->execute([':idProducto' => $idProducto]);
                    
                    $resultadoPI = $queryPI->fetchAll();
                    
                    
                    // foreach ($resultadoIng as $filaIng)
                    //     $arreglo1[] = $filaIng['id'];
                    $cont_pi_antes = 0;
                    foreach ($resultadoPI as $filaPI){
                        $arreglo2[] = $filaPI['idIngrediente'];
                        $cont_pi_antes++;
                    }
                    
                    
                    // foreach ($arreglo1 as $numero) {
                    //   if (in_array($numero, $arreglo2))
                    //     $ingredientesS[] = $numero;
                    // }
                    
                    $suma = 1;
                    echo "<table>";
                    echo "<tr><th>Ingrediente</th><th></th></tr>";
                    foreach ($resultadoIng as $filaIng) {
                        if(in_array($filaIng['id'],$arreglo2)){
                            echo "<label>";
                            echo "<tr>";
                            echo "<td>" . $filaIng['nombre'] . "</td>";
                            echo '<td><input type="checkbox" name="ingrediente'.$suma.'" value='.$filaIng['id'].' checked></td>';
                            echo "</tr>";
                            echo "</label>";
                        }else{
                            echo "<label>";
                            echo "<tr>";
                            echo "<td>" . $filaIng['nombre'] . "</td>";
                            echo '<td><input type="checkbox" name="ingrediente'.$suma.'" value='.$filaIng['id'].'></td>';
                            echo "</tr>";
                            echo "</label>";
                        }
                        $suma++;
                    }
                    echo "</table>";
                ?>
                <input type="submit" value="Actualizar Producto">
                <input type="button" value="Refrescar" class="boton-refrescar" onclick="location.reload()">
            </form>
        </div>
        <div>
            <?php
                $i = 1;
                $j = 0;
                while($i < $suma){
                    if(isset($_POST['ingrediente'.$i.''])){
                        $idIngrediente[$j] = $_POST["ingrediente$i"];
                        $j++;
                    }
                    $i++;
                }
                if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['gramos']) && isset($_POST['precio']) && isset($_POST['cantidad']) && isset($idIngrediente) && isset($_POST['categoria']) ){
                    $nombre = $_POST['nombre'];
                    $descripcion = $_POST['descripcion'];
                    $gramos = $_POST['gramos'];
                    $precio = $_POST['precio'];
                    $cantidad = $_POST['cantidad'];
                    $categoria = $_POST['categoria'];
                    
                    $nombre_imagen = $_FILES['imagen']['name'];
                    //Genera todos los varoles de nuestros ingredientes y comprueba que exista valor
                    
                    
                    
                    $actualizar = false;
                    if($nombre && $descripcion && $gramos && $precio && $cantidad && $idIngrediente && $idProducto &&  $categoria){
                        if($nombre_imagen){
                            $temporal = $_FILES['imagen']['tmp_name'];
                            $carpeta = '../img';//ruta
                            $ruta = $carpeta.'/'.$nombre_imagen;
                            move_uploaded_file($temporal,$carpeta.'/'. $nombre_imagen);
                        }
                        // Creamos una instancia de la clase Database
                        $db = new Database();
                        
                        $sql = "UPDATE producto SET nombre = :nombre, descripcion = :descripcion, gramos = :gramos,  precio = :precio, cantidad = :cantidad, imagen = :imagen, categoria = :categoria WHERE id = :idProducto";
                        $query = $db->connect()->prepare($sql);
                        
                        $query->bindParam(":nombre", $nombre);
                        $query->bindParam(":descripcion", $descripcion);
                        $query->bindParam(":gramos", $gramos);
                        $query->bindParam(":precio", $precio);
                        $query->bindParam(":cantidad", $cantidad);
                        $query->bindParam(":idProducto", $idProducto);
                        $query->bindParam(":imagen", $ruta);
                        $query->bindParam(":categoria", $categoria);
                        if($query->execute())
                            $actualizar = true;
                        
                        
                        
                        //si es menor el despues < antes compara los que son diferentes y (eliminaminarlos) 
                            //si todos son diferentes (agregarlos)
                        
                        //si son iguales compara los diferentes elimina y 
                        $m = 0;
                        $n = 0;
                        // if(($j < $cont_pi_antes) || ($cont_pi_antes == $j)){
                            foreach($idIngrediente as $fila){
                                if(in_array($fila,$arreglo2)){
                                    //no se hace nada con estos
                                    $ingredientes_igual[$m++] = $fila;
                                }else{
                                    $ingredientesdiferentes[$n++] = $fila;
                                }
                            }
                            //si hay datos en ingredientes_diferentes los comparamos en arreglo2 los que no aparecieron en arreglo2
                            $p = 0;
                            foreach($arreglo2 as $fila)
                                    if(!in_array($fila,$idIngrediente))
                                        $ingredientesnoestan[$p++] = $fila;
                            
                            //suplir con la consulta de update a los ingredientes que no estan y eliminar los restantes
                            //comprobar que falten diferentes
                            $update = false;
                            $eliminar = false;
                            $o = 0;
                            if(($n > 0)||($p > 0)){
                                while(($o < $p) && ($o < $n)){
                                    //suplir los direfentes con los que noestan y si sobran eliminarlos
                                    $sqlPI = "UPDATE productoIngrediente SET idIngrediente = :idIng WHERE idProducto = :idProducto AND idIngrediente = :ingredientenoesta";
                                    $queryPI = $db->connect()->prepare($sqlPI);
                                                                            
                                    $queryPI->bindParam(":idProducto", $idProducto);
                                    $queryPI->bindParam(":idIng", $ingredientesdiferentes[$o]);
                                    $queryPI->bindParam(":ingredientenoesta", $ingredientesnoestan[$o]);
                                    $o++;
                                    if ($queryPI->execute())
                                        $update = true;
                                }
                                if($o < $n){
                                    while($o < $n){
                                        $sqlPI = "INSERT INTO productoIngrediente (idProducto,idIngrediente) VALUES (?,?)";
                                        $queryIng = $db->connect()->prepare($sqlPI);
                                                
                                        $queryIng->bindParam(1, $idProducto);
                                        $queryIng->bindParam(2, $ingredientesdiferentes[$o]);
                                        $o++;
                                        if($queryIng->execute())
                                            $eliminar = true;
                                    }
                                }
                                if($o < $p){
                                    while($o < $p){
                                        $sqlElim = "DELETE FROM productoIngrediente WHERE idIngrediente = :id AND idProducto = :idProducto";
                                        $queryElim = $db->connect()->prepare($sqlElim);
                                                
                                        $queryElim->bindParam(":id",$ingredientesnoestan[$o]);
                                        $queryElim->bindParam(":idProducto", $idProducto);
                                        $o++;
                                        if($queryElim->execute())
                                            $eliminar = true;
                                    }
                                }
                                if (($update) || ($eliminar)) {
                                    echo "<div id='mensaje'><label>Producto e ingrediente actualizado correctamente <br>Refresca la pagina</label></div>";
                                    echo "<script>
                                            setTimeout(function() {
                                                document.getElementById('mensaje').style.display = 'none';
                                            }, 7000); // ocultar el mensaje después de 5 segundos
                                          </script>";
                                } else {
                                    echo "<label>no se pudo actualizar el producto e ingredientes</label>";
                                }
                            }else{
                                if($actualizar){
                                    echo "<div id='mensaje'><label>Producto e ingrediente actualizado correctamente <br>Refresca la pagina</label></div>";
                                    echo "<script>
                                            setTimeout(function() {
                                                document.getElementById('mensaje').style.display = 'none';
                                            }, 7000); // ocultar el mensaje después de 5 segundos
                                          </script>";
                                }
                            }
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