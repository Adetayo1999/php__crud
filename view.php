<?php
    include_once "db.php";
    include_once "dump.php";
    $pdo = Database();
   $id = $_POST['id'] ?? null;


   if(!$id){
       die("Bad Getaway <a href=\"index.php\">Go Back </a>");
   }

     $sql = "SELECT * FROM products WHERE id = ?";
     $stmt = $pdo->prepare($sql);

     if(!$stmt->execute([$id])){
         die("Error In Process <a href=\"index.php\">Go Back </a>");
     }


     $data = $stmt->fetch();





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']?></title>
    <link rel="stylesheet" href="../boot/bootstrap.min.css">
</head>
<body>
 <h1 class="p-3 text-center bg-warning text-white mb-5"><?php echo $data['title']?> Page</h1>
    <div class="container">
    <div class="row">
    <div class="col-md-4">
    <img src="<?php echo $data['title_image']?>" alt="No Image" width="250px" height="250px">
    </div>
    <div class="col-md-7">
        <h4 class="text-primary">Product Name: <?php echo $data['title']?></h4>
        <p class="lead">
        <h6>Price: <?php echo $data['price']?>$</h6>
        <?php echo $data['title_desc']?>
        </p>
        <small>Posted <?php echo $data['created_at']?></small>
        <div class="mt-3">
             <form action="delete.php" method="post" style="display:inline-block">
             <input type="hidden" name="id" value="<?php echo $data['id']?>">
             <button class="btn btn-danger mr-2">Delete Product</button>
             </form>
             <form action="edit.php" method="get" style="display:inline-block">
             <input type="hidden" name="id" value="<?php echo $data['id']?>">
             <button class="btn btn-primary">Edit Product</button>
             </form>
          <a type="button"  href="index.php" class="btn btn-success text-white ml-2" >Go Back</a>
        </div>
    </div>
    </div>
    </div>
    <?php include_once "footer.php"?>
</body>
</html>