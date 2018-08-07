<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$db = "tsarbucks";
 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error); 

session_start();
$_SESSION['message'] = "";

if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
  $username = $_POST['username'];
  $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
  $user = $result->fetch_assoc();

  if ($_POST['username'] == $user['username'] && $_POST['password'] == $user['password']){
    
    $_SESSION['username'] = $user['username'];
    $_SESSION['display_name'] = $user['display_name'];
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['valid'] = true;

    if($user['display_name'] == "Barista")
      header("location: orders_barista.php");
    else if ($user['display_name'] == "Customer")
      header("location: orders_customer.php");
  }
  else
    echo "Wrong User/Pass";
    $_SESSION['message'] = "Wrong Username or Password";
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
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
    </nav>

    <div id="mainbody" style="max-width: 700px; padding-top: 15px; margin: 0 auto">
      <h1>Login</h1>

      <form action='login.php' method='post'>
        <div class="form-group">
          <input type="text" class="form-control" id="userfield" name="username" aria-describedby="emailHelp" placeholder="Username">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="passfield" name="password" placeholder="Password">
        </div>
        <button type="submit" name="login" class="btn btn-primary">Log In</button>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>