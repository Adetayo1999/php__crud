<?php

 include_once "db.php";
    include_once "dump.php";
    $pdo = Database();
   $id = $_POST['id'] ?? null;


   if(!$id){
       die("Bad Getaway <a href=\"index.php\">Go Back </a>");
   }

     $sql = "DELETE FROM products WHERE id=:id";

     $stmt = $pdo->prepare($sql);

     if($stmt->execute(['id'=>$id])){
         header("Location:index.php");
     }





?>