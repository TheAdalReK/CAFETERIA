<?php
    session_start();

    if(!isset($_SESSION['rol'])){
        header('location: ../login.php');
    }else{
        if($_SESSION['rol'] != 1){
           header('location: ../login.php');
        }
    }
include_once '../database.php';

if (isset($_POST['id'])) {
    $db = new Database();
    
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $query = $db->connect()->prepare($sql);
    $query->bindParam(":id", $_POST['id']);
    if ($query->execute()) {
        echo "El Empleado se ha eliminado correctamente.";
    } else {
        echo "No se pudo eliminar el Empleado.";
    }
}
?>