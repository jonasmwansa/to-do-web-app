<?php

require_once 'resources/forms/connection.php';

session_start();

if(isset($_SESSION["loggedin"])) //check condition session user login not direct back to index.php page
{
 header("location: resources/content.php");
}

    $email_err=$password_err=$login_err="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {

        $email  =trim($_POST["email"]);
        $email = stripslashes($email);
        $password =trim($_POST["password"]);
        
        if(empty($email))
        {
            $email_err="please enter username or email"; //check "username/email" textbox not empty 
        }
        else if(empty($password)){

            $password_err="please enter password"; //check "passowrd" textbox not empty 
        }else
            {        
                
                try{
                        
                        $query=$conn->prepare("SELECT * FROM users WHERE email=:email");
                        $query->bindParam(':email', $email);
                        $query->execute();
                        
                        if($query->rowCount() > 0) //check condition database record greater zero after continue
                        {
                            while($row=$query->fetch())
                            {
                                if(password_verify($password, $row["password"]))
                                {
                                    $_SESSION["email"] = $_POST["email"]; 
                                    $_SESSION["loggedin"] = true;
                                            
                                    header("refresh:1;url= resources/content.php");
                                    
                                    }else{
                                            $password_err= 'wrong password';    
                                        }   
                            }
                        }else{
                                $email_err="no account exists for this user";
                             }
                     
                    }catch(PDOException $exception){
                    
                        echo" an error occured ". $exception->getMessage();    
                    }  
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>to do list app home</title>
    <!-- link bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="resources/css/styles.css">
</head>
<body>
    <div class="container">
     <h4 class="text-center">WELCOME TO YOUR TO DO APP</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="jomlink@gmail.com"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"     
                >
                    <span class="invalid-feeconnack"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                >
                <span class="invalid-feeconnack"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="sign in" name="submit">
                <span class="invalid-feeconnack"><?php echo $login_err; ?></span>
            </div>
            <p>You don't have an account? <a href="resources/forms/handlesignup.php">Sign up here</a>.</p>
        </form>
    </div>
</body>
</html>