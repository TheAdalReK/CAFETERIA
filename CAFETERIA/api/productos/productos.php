<?php
include_once '../../database.php';
    
    class Productos extends Database{
        
        function __construct(){
            parent::__construct();
        }
        
        public function get($id){
            //ingredientes cantidad
            $query = $this->connect()->prepare('SELECT id,nombre,precio,imagen,categoria FROM producto WHERE id = :id');
            $query->execute(['id' => $id]);
            
            $row = $query->fetch();
            
            return [
                'id'         => $row['id'],
                'nombre'     => $row['nombre'],
                'precio'     => $row['precio'],
                'categoria'  => $row['categoria'],
                'imagen'     => $row['imagen'],
            ];
        }
        
        public function getItemsByCategory($category){
            $query = $this->connect()->prepare('SELECT * FROM producto WHERE categoria = :cat');
            $query->execute(['cat' => $category]);
            
            $items = [];
            
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $item = [
                'id'         => $row['id'],
                'nombre'     => $row['nombre'],
                'precio'     => $row['precio'],
                'categoria'  => $row['categoria'],
                'imagen'     => $row['imagen'],
                ];
                
                array_push($items,$item);
            }
            
            return $items;
        }
    }
    
?>