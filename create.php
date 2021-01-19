<?php

    include_once "db.php";
    include_once "dump.php";
    $pdo = Database();
 function Clean($data){
    $text = trim($_POST[$data]);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);

    return $text;
}
$title = $image = $price = $description = $msg = $msgClass = $imagePath =  "";

      if(filter_has_var(INPUT_POST , 'submit')){
           $title = Clean("title");
           $price = Clean("price");
           $description = $_POST["description"];
           $image = $_FILES['image'] ?? null;
     
            if(!is_dir("uploads")){
                mkdir("uploads");
            }

             if(!empty($title) && !empty($price)){
                 
             if($image['tmp_name'] !== "" ){

                if($image['size'] <= 500000){


                 
                    $imagePath ="uploads/". randomString(12) ."/".$image['name']; 
                   
                       mkdir(dirname($imagePath));

                       move_uploaded_file($image['tmp_name'] , $imagePath);

                     
                }else{
                    $msg ="Image Size Cannot Exceed 500kb";
                    $msgClass="danger";
                }
                
             }
             $sql = "INSERT INTO products(title , title_image , price , title_desc) VALUES(:title , :imaging , :price , :descript)";

             $stmt = $pdo->prepare($sql);
             if($stmt->execute(['title'=>$title , 'imaging'=>$imagePath , 'price' =>$price , "descript" => $description])){
                  header("Location:index.php");
             }else{
                 $msg="Error Submitting Form";
                 $msgClass-"danger";
             }
             }
             else{
                 $msg = "Title And Price Must Not Be Empty";
                 $msgClass="danger";
             }

      }

       function randomString($n){
           $characters =  "0123456789abcdefghjklmnopqrstvvwxyzABCDEFGHJKLMNOPQRSTVVWXYZ";
           $str ="";

           for($i=0;$i<$n;$i++){
               $randy = rand(0 , strlen($characters) - 1);
               $str .= $characters[$randy];

               
           }
           return $str;
       }

      







?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="../booted/bootstrap.min.css">
</head>
<body>
<h1 class="mb-3 p-2 text-center text-white bg-success">Add Products</h1>

   <div class="container">
       <div class="<?php echo $msg ? "alert alert-$msgClass" : ""?>">
          <?php echo $msg ? $msg : ""?>
       </div>
   <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
     <div class="row">
         <div class="col-md-6 form-group mb-3">
             <label for="title" class="mb-1">Product Title:</label>
             <input type="text" class="form-control" name="title" value="<?php echo $title?>">
         </div>
         <div class="col-md-6 ">
            <div class="form-group mb-3">
            <label for="image" class="mb-1">Choose Image</label>
             <input type="file" name="image" class="form-control" value="<?php echo $image?>">
            </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12">
             <div class="form-group mb-3">
            <label for="price" class="mb-1">Price:</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?php echo $price?>">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12">
             <div class="form-group mb-3">
            <label for="price" class="mb-1">Description:</label>
            <textarea name="description"  cols="30" rows="6" class="form-control"><?php echo $description?></textarea>
             </div>
         </div>
     </div>
     <input type="submit" value="Submit" class="form-control btn btn-dark" name="submit">
</form> 
   </div>
   <?php include_once "footer.php"?>
</body>
</html>