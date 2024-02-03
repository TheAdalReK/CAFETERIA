<!DOCTYPE html>
<html>
<head>
	<title>Verificacion</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			background-color: #a85400;
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
    include_once("database.php");
    $code=$_GET['code'];
    
    $db = new Database();
    $query = $db->connect()->prepare('UPDATE usuarios SET status = 1 WHERE activationcode = :code ');
    $query->execute(['code' => $code]);
    
    if($query){
        echo "<div class='mensaje'>";
            echo "Cuenta verificada correctamente, ahora puede iniciar sesión!";
            echo "<br>";
            echo "<a href='https://cafeteriamineral.000webhostapp.com/login.php'>Click Aqui para dirigirse al Login";
        echo "</div>";
    }else{
        echo "<div class='mensaje'>";
            echo "Error";
        echo "</div>";
    }
    ?>
</body>
</html>