<?php
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../login.php');
}else{
    if($_SESSION['rol'] != 2){
        header('location: ../login.php');
    }
}

$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        $db = new Database();
        $sql = "UPDATE `notificaciones` SET `idEmpleado` = :idEmpleado, estado = 1 WHERE `notificaciones`.`id` = :id";
        $query = $db->connect()->prepare($sql);
        $query->bindParam(":idEmpleado", $_SESSION['id']);
        $query->bindParam(":id", $id);
        if($query->execute()){
            echo "<div class='mensaje'>";
                echo "Comienza el pedido";
            echo "</div>";
        }else{
            echo "<div class='mensaje'>";
                echo "No se puede comenzar el pedido";
            echo "</div>";
        }
    ?>
</body>
</html>

<script>
    setTimeout(function() {
        window.location.href = "abrirPedido.php?id=<?php echo $id; ?>";
    }, 3000); // tiempo en milisegundos (en este caso, 3 segundos)
</script>