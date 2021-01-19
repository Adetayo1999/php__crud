<?php

    include_once "db.php";
    include_once "dump.php";
    $pdo = Database();


    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    if(!$stmt->execute()){
        die("Error Retrieving Data From The Base");
    }

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   


    if(filter_has_var(INPUT_POST , 'deleteall')){
        $sql = "DROP TABLE products";
          $stmt = $pdo->prepare($sql);

             $stmt->execute();


      }
 





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cruded Application</title>
    <link rel="stylesheet" href="../boot/bootstrap.min.css">
    <style>
       
    </style>
</head>
<body>
    <h1 class="mb-3 p-3 text-center text-white bg-info">My Products</h1>
    <div class="container">
       <p style="display: inline-block;">
           <a href="create.php" class="btn btn-success">Add A Product</a>
       </p>
       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"  style="display:inline-block">
          <input type="submit" value="Delete All" name="deleteall" class="btn btn-danger">
       </form>
    <table class="table table-bordered">
        <thead class="bg-info text-white">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price ($)</th>
                <th>Date</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $key => $datum):?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><img src="<?php echo !empty($datum['title_image']) ? $datum['title_image'] : "apple.jpg"?>" alt="Image" style="width:50px;height:50px;"></td>
                <td><?php echo $datum['title']?></td>
                <td><?php echo $datum['price']?>$</td>
                <td><?php echo $datum['created_at']?></td>
                <td>
                    <form method="post" action="view.php">
                        <input type="hidden" name="id" value="<?php echo $datum['id']?>">
                        <button type="submit" class="btn btn-outline-primary">View</button>
                    </form>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </div>
    <?php include_once "footer.php"?>
</body>
</html>

