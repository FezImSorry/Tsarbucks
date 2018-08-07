<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$db = "tsarbucks";
 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error); 
session_start();

if (isset($_POST['remove'])) {

  $id = $_POST['pid'];
  $conn->query("DELETE FROM cart WHERE product_id = '$id'");
}

if (isset($_POST['submitOrder'])) {

  $userid = $_SESSION['user_id'];

  $orderResult = $conn->query("SELECT order_id FROM orders ORDER BY order_id DESC");
  $latestOrder = $orderResult->fetch_assoc();
  $orderid = $latestOrder['order_id'] + 1;

  if ($result = $conn->query("SELECT * FROM cart")) {
    while($item = $result->fetch_assoc()) {

      $id = $item['product_id'];
      $quantity = $item['quantity'];

      $conn->query("INSERT INTO orders (order_id, user_id, product_id, quantity, completed) VALUES ('$orderid', '$userid', '$id', '$quantity', 0)");
      $conn->query("DELETE FROM cart WHERE product_id = '$id'");
    }
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>HotCoffee - Menu</title>
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
          <a class="nav-item nav-link active"> Welcome <?php echo $_SESSION['display_name']; ?>!</a>
          <a class="nav-item nav-link" href="orders_customer.php">Orders</a>
          <a class="nav-item nav-link active" href="cart.php">Cart</a>
          <a class="nav-item nav-link" href="menu.php">Menu<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="logout.php">Log Out</a>
        </div>
      </div>
    </nav>

    <div id="mainbody" style="max-width: 1000px; padding-top: 15px; margin: 0 auto">
      <h1>Cart</h1>
      
      <?php 

      $totalPriceCounter = 00.00;

      echo '
      <table class="table table-hover" id="inbox">
          <thead class="thead-dark">
            <tr>        
              <th>Product</th>
              <th>Size (oz)</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Cancel</th>
            </tr>
          </thead>
          <tbody>';

      if ($result = $conn->query("SELECT * FROM cart")) {
        while($item = $result->fetch_assoc()) {        

            echo '
            <tr>
              <th>'.$item['display_name'].'</th>
              <th>'.$item['size'].'</th>
              <th>$'.$item['price'].'</th>
              <th>'.$item['quantity'].'</th>
              <th>
               <form action="cart.php" method="post">
               <input type="hidden" name="pid" value="'.$item['product_id'].'" />
                <button type="submit" name="remove" class="btn btn-outline-danger">Remove from Cart</button>
               </form>
               </th>
            </tr>';

            $totalPriceCounter = $totalPriceCounter + $item['price'];
        }
      } 
      
      echo'
          </tbody>
        </table>
        <h5 style="text-align: right;"><b>Cart Total:</b> $'.$totalPriceCounter.'</h5>
        <form action="cart.php" method="post">
          <button type="submit" name="submitOrder" class="btn btn-outline-success">Submit Order</button>
        </form>';

      ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>