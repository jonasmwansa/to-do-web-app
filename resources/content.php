<?php

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!(isset($_SESSION["loggedin"]))){
    header("location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do list App</title>

    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" charset="utf-8">    
    <!--link boostrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
    <div class="text-center">
      <img src="images/to-do-list.png" class="rounded" alt="logo">
    </div>
      <h5>Add New Task</h5>
        <p>
            <input type="text" id="add-task"><button class="btn btn-success">Add</button>
        </p>
      <h5>Todo's</h5>
      <ul id="incomplete-tasks">
      </ul>
      
      <h5>Completed</h5>
      <ul id="completed-tasks">
      </ul>
          <a class="btn btn-primary" href="signout.php" role="button">Sign Out</a>
    </div>
    <!--script inclusion-->
    <script src="js/index.js" type="text/javascript"></script>
  </body>
</html>