<?php
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../login.php');
}else{
    if($_SESSION['rol'] != 3){
        header('location: ../login.php');
    }
}


include_once '../database.php';
    
    $db = new Database();
    $sql = "SELECT * FROM notificaciones WHERE idUsuario = :id  AND estado != 2 ";
    $query = $db->connect()->prepare($sql);
    $query->bindParam(":id", $_SESSION['id']);
    $query->execute();
    
    $resultado = $query->fetchAll();
    
    $notificaciones = array();
    foreach($resultado as $row){
        $notificacion = array(
            'id' => $row['id'],
            'fechaPublicacion' => $row['fechaPublicacion'],
            'descripcion' => $row['descripcion'],
            'estado' => $row['estado'],
            'nombre' => $row['nombre'],
            'idUsuario' => $row['idUsuario'],
            'idEmpleado' => $row['idEmpleado'],
            'idGerente' => $row['idGerente'],
        );
        $notificaciones[] = $notificacion;
    }
    
    echo json_encode($notificaciones);

?>