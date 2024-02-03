<?php
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../login.php');
}else{
    if($_SESSION['rol'] != 2){
        header('location: ../login.php');
    }
}


include_once '../database.php';
    
    $db = new Database();
    $sql = "UPDATE `notificaciones` SET `idEmpleado` = :idEmpleado WHERE `notificaciones`.`id` = :id";
    $query = $db->connect()->prepare($sql);
    $query->bindParam(":idEmpleado", $_SESSION['id']);
    $query->bindParam(":id", $_POST['id']);
    $query->execute();
?>