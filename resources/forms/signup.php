
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Signup-Login</title>
    <link rel="stylesheet" href="/resources/css/styles.css">
</head>
<body>
    <section>
        <div class="logo">
            <a href="../../index.php">
                <img src="/resources/images/todologo.png" alt="logo">
            </a>
        </div>
        <div class="signup-title">
            <p>Sign up</p>
        </div>

        <div class="signup-form">
            <form action="handle" method="post" class="info">
                <label for="name">Name</label>
                <br>
                <input type="text" name="name" placeholder="full name e.g oliver mtukuzi"/>
                <br>
                <br>
                <label for="email">Email </label>
                <br>
                <input type="email" name="email" placeholder="Enter your email address"/>
                <br>
                <br>
                <label for="password">Password</label>
                <br>
                <input type="password" name="password"/>
                <br>
                <br>
                <label for="confirm-password">Password</label>
                <br>
                <input type="password" name="confirm-password"/>
                <br>
                <br>
                <button>Sign up</button>
            </form>
            <div class="switch-signup">
                <p>You have an account already? <a href="../../index.php">signin here</a></p>
            </div>
        </div>
    </section>
    <footer>
        <div class="copyright">
            <p>Copyright &copy; 2022 <a href="../../index.php">yourtodolist.com</a>  All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>