<?php
require ("db.php");
session_start();
$msg = '';

if (isset($_POST['cpassword'])) {
    $email = $_POST['email'];
    $newpassword = md5($_POST['newpassword']);

    // Check if email exists
    $query = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Update the password
        $updateQuery = "UPDATE users SET pass='$newpassword' WHERE email='$email'";
        $res = mysqli_query($conn, $updateQuery);
        if ($res) {
            echo '<script>alert("Password reset successfully."); 
                window.location.replace("index.php");</script>';
            exit();
        } else {
            $msg = "Error updating password.";
        }
    } else {
        $msg = "Email ID not found.";
    }
} else {
    $msg = "Invalid email format.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Update Password</div>
            <div class="card-body">

                <div class="alert alert-danger">
                    <?php echo $msg ?>
                </div>

                <!-- Reset password form -->
                <form method="post" name="loginform">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                required="required" autofocus="autofocus">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="newpassword" class="form-control" placeholder="New Password"
                                required="required">
                            <label for="newpassword">New Password</label>
                        </div>
                    </div>
                    <input type="submit" name="cpassword" value="Update Password" class="btn btn-primary btn-block">
                    <br>
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