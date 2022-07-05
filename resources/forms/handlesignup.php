<?php
session_start();

require_once("connection.php");


if($_SERVER["REQUEST_METHOD"] === "POST")
{

    //initialise empty error variables
    $username_err=$email_err=$password_err=$error="";

    //get values
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

        //check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err= "Please enter your user name.";
        } else
        {
            $username= trim($_POST["username"]);
        }

        // Check if email is empty and validate it
        if(empty(trim($_POST["email"])))
        {
            $email_err = "Please enter your email.";
        }else
            {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $email_err = "Enter a  valid email";
                }

                $email = trim($_POST["email"]);
            }

    // Check if password is empty
    if(empty(trim($_POST["password1"])))
    {
        $password_err = "Please enter your password."; 
    }else
    {

        $password1 = trim($_POST["password1"]);
        // checking the password length
        if(strlen($password1) < 8)
        {
            $password_err = "A password should be longer than 7 characters";
        }   
            if(empty(trim($_POST["password2"])))
            {
                $password_err = "Please enter the confirmation password field."; 
            }
                // Password match
                $password2 = $_POST['password2'];
                if($password1 != $password2)
                {
                    $password_err = "The passwords are not matching match";
                }

                //hashing the password 
                $password1 = password_hash($password1, PASSWORD_DEFAULT);
    }

        //check if any of the feilds are empty
        if(empty($username) || empty($email) || empty($password1) || empty($password2))
        {
            $error = "Complete all the fields";
        }else
            {
                //if there are no empty fields we check if a user exists using the email
                if (!isset($error)) 
                {
                    $checkquery = $conn->prepare("SELECT email FROM users WHERE email =:email");
                    $checkquery->bindParam(':email', $email);
                    $checkquery->execute();

                    if($checkquery->rowCount() > 0) {
                        $email_err = "account already exists, go to login";
                        return;
                    } else 
                    {
                        //try to insert into database
                        try 
                        {
                            $insertquery = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password1)';
                            $query = $conn->prepare($insertquery);

                            $query->execute(
                                array(
                                ':username' => $username,
                                ':email' => $email,
                                ':password1' => $password1
                                )
                            );
                            
                            if($query)
                            {
                                //if an account is created, redirect them to the app immediately
                                $_SESSION['email'] = $_POST['email'];
                                $_SESSION['loggedin'] = true;
                                header("Location: ../content.php");   
                            }else{

                                $error = "an error occured account cannot be created";

                            }

                        } catch (PDOException $except) {
                            die("An error occured " . $except->getMessage());
                        }
                    }
                } else
                    {
                        $error = 'something happened, account cannot be created';
                    }
        }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="container">
        <h2 class="text-center">Create Account</h2>
        <p>Please fill this form to create an account.</p>
        <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    placeholder="jonas mwansa"
                >
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="mailjom@gmail.com">
                <span class="invalid-feedback"><?php echo $email_err ; ?></span>
            </div>
            <div class="form-group">
                <label for="password1">Password</label>
                <input 
                    type="password" 
                    name="password1"
                    id="password1"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                >
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password2">Confirm Password</label>
                <input 
                    type="password" 
                    name="password2" 
                    id="password2"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                >
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-secondary" value="Submit" id="submit">
                <span class="invalid-feedback"><?php echo $error; ?></span>
            </div>

            <p>Already have an account? <a href="../../index.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
