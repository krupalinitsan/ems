<?php
require ("db.php");
session_start();

$error = '';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    // $password = $_POST['password'];
    $password = md5($_POST['password']);

    // Server-side validation
    if (empty($email) || empty($password)) {
        $error = 'Email and Password are required.';
    } else {
        $sql = "SELECT * FROM `users` WHERE email='$email' AND pass='$password'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        if ($row) {
            $_SESSION['ROLE'] = $row['role'];
            $_SESSION['IS_LOGIN'] = 'yes';
            $_SESSION['ID'] = $row['id'];
            ?>
            <script>
                alert("Login successful");
                window.location.replace("dashboard.php");
            </script>

            <?php
        } else {
            $error = 'Please enter correct login details.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="post" name="loginform" onsubmit="return validateForm()">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                required="required" autofocus="autofocus" id="email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                required="required" id="password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login">
                    <div>
                        Not Registered? <a href="register.php">Create an account</a><br>
                        Forgot password? <a href="resetpassword.php">Reset password</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email == "" || password == "") {
                alert("Email and Password must be filled out");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>