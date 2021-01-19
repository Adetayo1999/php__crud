<?php
     include_once "constants.php";


       function Database(){ 


            try{
                $dsn ="mysql:host=".HOST;

                $pdo = new PDO($dsn , DB_USER , DB_PASS);
                
            }
            catch(Exception $e){
                die("Error In Connection ".$e->getMessage());
            }

          $sql = "CREATE DATABASE IF NOT EXISTS ".DB_NAME;


          $stmt = $pdo->prepare($sql);
          
          if($stmt->execute()){
             
            $dsn ="mysql:host=".HOST.";dbname=".DB_NAME;
            $pdo = new PDO($dsn , DB_USER , DB_PASS);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        //   $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
             $sql = "CREATE TABLE IF NOT EXISTS products(
               id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
               title VARCHAR(150) NOT NULL UNIQUE ,
               title_desc TEXT NOT NULL ,
               title_image VARCHAR(255) NOT NULL ,
               price FLOAT NOT NULL ,
               created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
             ); ";

             $stmt = $pdo->prepare($sql);

             if($stmt->execute()){
                  return $pdo;
             }else{
                 die("Not Created");
             }


          }else{
            die("Base Not Created");
          }



       }


  





?>