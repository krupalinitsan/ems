<?php
require ("db.php");
$error = '';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $password = md5($_POST['password']);
    $sql = "SELECT * FROM `users` WHERE email='$email' AND pass='$password' ";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        session_start();
        $_SESSION['ROLE'] = $row['role'];
        $_SESSION['IS_LOGIN'] = 'yes';
        $_SESSION['ID'] = $row['id'];
        if ($_SESSION['ID']) {
            header("Location:index.php");
            die();
        }
    } else {
        $error = 'Please enter correct login details';
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
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-light">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="post" name="loginform">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="username" name="email" class="form-control" placeholder="Username"
                                required="required" autofocus="autofocus">
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary btn-block">
                    <div>
                        Not Registered ?<a href="register.php"> craete an account</a><br>
                        Forgot password ? <a href="resetpassword.php"> reset password</a>
                    </div>
                    <?php echo $error ?>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>