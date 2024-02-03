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
<html>
<head>
	<title>Mensaje</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			background-color: black;
		}
		
		.mensaje {
			color: white;
			font-size: 5em;
			text-align: center;
		}
	</style>
</head>
<body>
	<?php
        include_once '../database.php';
        if(isset($_POST['carrito'])){
            $carritoJSON = $_POST['carrito'];
            $items = json_decode($carritoJSON);
            
            $ids = [];
            $cantidad_ids = [];
            
            date_default_timezone_set('America/Mexico_City');
            $fecha_actual = date('Y-m-d');
            $estado = 0;
            if($items){
                $descripcion = "";
                foreach ($items as $item) {
                    
                    $ids[] = $item->id;
                    $cantidad_ids[] = $item->cantidad;
                    
                    $id = $item->id;
                    $nombre =   $item->nombre;
                    $precio =   $item->precio;
                    $imagen =   $item->imagen;
                    $cantidad = $item->cantidad;
                    $subtotal = $item->subtotal;
                    
                    $descripcion .= $id . ',' . $nombre . ',' . $precio . ',' . $imagen . ',' . $cantidad . ',' . $subtotal. ',';
                }
                
                $i = 0;
                //se compara si existen la cantidad necesaria de ingredientes para realizar el pedido 
                //si count es mayor a 0 quiere decir que hay más productos que ingredientes y no se realiza la venta
                $count = 0; // Inicializamos el contador de ingredientes que cumplen la condición
                foreach($ids as $id){
                    $db = new Database();
                    $sql = "SELECT idIngrediente FROM productoIngrediente WHERE idProducto = :idProducto";
                    $query = $db->connect()->prepare($sql);
                    
                    $query->bindParam(":idProducto", $id);
                    $query->execute();
                    $rows = $query->fetchAll();
                    foreach($rows as $row) {
                        $sql = "SELECT count(*) from ingrediente WHERE id = :idIngrediente AND cantidad < :cantidad";
                        $query = $db->connect()->prepare($sql);
                        $query->bindParam(":cantidad", $cantidad_ids[$i]);
                        $query->bindParam(":idIngrediente", $row['idIngrediente']);
                        $query->execute();
                        
                        $result = $query->fetchColumn(); // Almacenamos el número de filas devuelto
                        $count += $result; // Añadimos el resultado al contador
                    }
                    $i++;
                }
                if( $count > 0){
                    echo "<div class='mensaje'>";
                        echo "<p>no se pudo realizar el Pedido no quedan más ingredientes o intenta pedir menos productos</p>";
                    echo "</div>";
                }else{
                    $db = new Database();
                    $sql = "INSERT INTO notificaciones (fechaPublicacion, descripcion, estado, nombre, idUsuario) VALUES (?, ?, ?, ?, ?)";
                    $query = $db->connect()->prepare($sql);
                            
                    
                    $query->bindParam(1, $fecha_actual);
                    $query->bindParam(2, $descripcion);
                    $query->bindParam(3, $estado);
                    $query->bindParam(4, $_SESSION['nombre']);
                    $query->bindParam(5, $_SESSION['id']);
                    $query->execute();
                    $i = 0;
                    if ($query->rowCount() > 0) {
                        foreach($ids as $id){
                            $sql = "SELECT idIngrediente FROM productoIngrediente WHERE idProducto = :idProducto";
                            $query = $db->connect()->prepare($sql);
                            
                            $query->bindParam(":idProducto", $id);
                            $query->execute();
                            $rows = $query->fetchAll();
                            foreach($rows as $row) {
                                
                                $sql = "UPDATE ingrediente SET cantidad = cantidad - :cantidad WHERE id = :idIngrediente";
                                $query = $db->connect()->prepare($sql);
                                $query->bindParam(":cantidad", $cantidad_ids[$i]);
                                $query->bindParam(":idIngrediente", $row['idIngrediente']);
                                $query->execute();
                            }
                            $i++;
                        }
                        echo "<div class='mensaje'>";
                            echo "<p>Pedido realizado correctamente</p>";
                        echo "</div>";
                        
                    } else {
                        echo "<div class='mensaje'>";
                            echo "<p>no se pudo realizar el Pedido</p>";
                        echo "</div>";
                    }
                }
            }else{
                echo "<div class='mensaje'>";
                    echo "<p>Items Vacios</p>";
                echo "</div>";
            }
        }
        ?>
</body>
</html>
<script>
    setTimeout(function() {
        window.location.href = "bebidascalientes.php";
    }, 3000); // tiempo en milisegundos (en este caso, 3 segundos)
</script>