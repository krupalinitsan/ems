<?php
require ("db.php");
$msg = '';
session_start();
if (isset($_POST['cpassword'])) {
    $email = $_POST['email'];
    $newpassword = $_POST['newpassword'];
    // $password = md5($_POST['password']);
    $query = "UPDATE users SET pass='$newpassword' WHERE email='$email'";
    $res = mysqli_query($conn, $query);
    if ($res) {
        $msg = "password updated sucessfully";
    } else {
        $msg = "email id not found";
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

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Update Password</div>
            <div class="card-body">
                <!-- reset password form -->
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
                            <input type="password" name="newpassword" class="form-control" placeholder="Password"
                                required="required">
                            <label for="inputPassword">New Password</label>
                        </div>
                    </div>

                    <input type="submit" name="cpassword" value="Update Password" class="btn btn-primary btn-block">
                    <br>
                    <?php echo $msg ?>
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