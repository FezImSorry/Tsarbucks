<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$db = "tsarbucks";
 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error); 
session_start();

if (isset($_POST['complete'])) {
  $order_id = $_POST['oid'];
  $product_id = $_POST['pid'];

  $conn->query("UPDATE orders SET completed = 1 WHERE order_id = '$order_id' AND product_id = '$product_id'");
}
  
?>

<!doctype html>
<html lang="en">
  <head>
    <title>HotCoffee - Barista</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand">HotCoffee<sup style="font-size: 8px; line-height: 0; vertical-align: 3px">Mod</sup></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="orders_barista.php"> Welcome <?php echo $_SESSION['display_name']; ?>!<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="logout.php">Log Out</a>
        </div>
      </div>
    </nav>

    <div id="mainbody" style="max-width: 1000px; padding-top: 15px; margin: 0 auto">
      <h1>Pending Orders</h1>
      <h3 style="padding-top: 10px;">Orders for Customer:</h3>
      
      <?php 

      echo '
      <table class="table table-hover" id="inbox">
          <thead class="thead-dark">
            <tr>
              <th>Order #</th>          
              <th>Product</th>
              <th>Size (oz)</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>';

      if ($orderResult = $conn->query("SELECT * FROM orders WHERE completed = 0")) {
        while($orders = $orderResult->fetch_assoc()) {        
            
            $oid = $orders['order_id'];
            $pid = $orders['product_id'];
            $productResult = $conn->query("SELECT * FROM products WHERE product_id = '$pid'");
            $product = $productResult->fetch_assoc();

            echo '
            <tr>
              <th>'.$oid.'</th>
              <th>'.$product['display_name'].'</th>
              <th>'.$product['size'].'</th>
              <th>'.$orders['quantity'].'</th>
              <th>$'.$product['price'].'</th>
              <th>
               <form action="orders_barista.php" method="post">
                <input type="hidden" name="oid" value="'.$oid.'" />
                <input type="hidden" name="pid" value="'.$pid.'" />
                <button type="submit" name="complete" class="btn btn-outline-success">Mark Complete</button>
               </form>
               </th>
            </tr>';
        }
      } 
      
      echo'
          </tbody>
        </table>';
      ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>