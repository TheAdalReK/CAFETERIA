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
    
    $sqlPI = "SELECT COUNT(*) FROM productoIngrediente WHERE idProducto = :idp";
    $queryPI = $db->connect()->prepare($sqlPI);
    $queryPI->bindParam(":idp", $_POST['id']);
    $queryPI->execute();
    $count = $queryPI->fetchColumn();
    
    if ($count > 0) {
        $sqlDelete = "DELETE FROM productoIngrediente WHERE idProducto = :idp";
        $queryDelete = $db->connect()->prepare($sqlDelete);
        $queryDelete->bindParam(":idp", $_POST['id']);
    
        while ($count > 0) {
            $queryDelete->execute();
            $count = $queryDelete->rowCount();
        }
    }
    
    
    $sql = "DELETE FROM producto WHERE id = :id";
    $query = $db->connect()->prepare($sql);
    $query->bindParam(":id", $_POST['id']);
    if ($query->execute()) {
        echo "El producto se ha eliminado correctamente.";
    } else {
        echo "No se pudo eliminar el producto.";
    }
}
?>