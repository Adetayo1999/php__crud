<?php
     
include_once "db.php";
include_once "dump.php";
$pdo = Database();
$id = $_GET['id'] ?? null;

  


if(!$id){
   die("Bad Getaway <a href=\"index.php\">Go Back </a>");
}

$sql = "SELECT * FROM products WHERE id =?";
$stmt = $pdo->prepare($sql);

if(!$stmt->execute([$id])){
    die("Error In Process <a href=\"index.php\">Go Back </a>");
}


$data = $stmt->fetch();
$msg = "";
$msgClass="";
  $title=$data['title'];
  $image=$data['title_image'];
  $price=$data['price'];
  $description=$data['title_desc'];
  function Clean($data){
    $text = trim($_POST[$data]);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);

    return $text;
}



      if(isset($_POST['update'])){
        
              $title = Clean('title');
              $image = $_FILES['image'];
              $price = Clean('price');
              $description = Clean('description');
               

                if(!is_dir('uploads')){
                    mkdir('uploads');
                }


           if(!empty($title) && !empty($price)){
                  if($image['tmp_name'] !== ""){
                    
                       unlink($data['title_image']);
                    $imagePath = "uploads/".randomString(12)."/".$image['name'];         
             mkdir(dirname($imagePath));
             move_uploaded_file($image['tmp_name'] , $imagePath );
                        
                  }else{
                       $imagePath = $data['title_image'];
                  }
               
                   
                  $sql = "UPDATE products SET title = :title , price = :price , title_image = :imaging , title_desc = :descript WHERE id=:id";
                    $stmt = $pdo->prepare($sql);
                    if($stmt->execute([
                        'title'=>$title,
                        'price'=>$price,
                        'imaging'=> $imagePath,
                        'descript'=>$description,
                        'id'=>$id
                    ])){
                         header("Location:index.php");
                    }else{
                        $msg ="Error In Updating Product";
                        $msgClass="danger";
                    }
              
           }else{
                $msg = "Title And Price Are Required";
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
    <title><?php echo $data['title']?> Update</title>
    <link rel="stylesheet" href="../booted/bootstrap.min.css">
    <style>
    
    img{
        height:250px;
        width:250px;
      
    }
    @media(min-width:1000px){
        img{
            height:360px;
            width:360px;
           
        }
    }
    </style>
</head>
<body>
    <h1 class="mb-3 p-3 bg-primary text-center text-white">Update <?php echo $data['title']?></h1>
    <div class="container"> 
    <div class="row">
    <div class="col-md-4">
    <img src="<?php echo $data['title_image']?>" alt="No Image" >
    <a href="index.php" class="btn btn-secondary">Go Back</a>
    </div>
      <div class="col-md-8">
      <div class="<?php echo $msg ? "alert alert-$msgClass" : "" ;?>">
      <?php echo $msg ? $msg : ""; ?>
      </div>
      <form  method="post" enctype="multipart/form-data">
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
     <button type="submit"  class="form-control btn btn-dark" name="update">Update</button>
      </form>
      </div>
    </div>
    </div>
    <?php include_once "footer.php"?>
</body>
</html>