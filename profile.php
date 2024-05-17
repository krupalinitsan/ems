<?php
session_start();
require ("db.php");
$msg = "";
if (isset($_POST['update'])) {

    $id = $_SESSION['ID'];
    echo "$id";
    //fetch $_post values 
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    // $password = md5($_POST['password']);
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET firstname='$fname' ,middlename='$mname ',lastname=' $lname',pass='$password',email='$email' WHERE id=$id";
    $data = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($data);
    if ($data) {

        $msg = "data updated sucessfully";
        header("location: index.php");
    } else {
        $msg = "please enter valid details";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>update profile</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Update Profile</div>
            <div class="card-body">
                <!-- update user profile -->
                <form id="registrationForm" method="post" action="" name="employeeForm"
                    onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                            <span class="error text-danger" id="fnameError"></span>
                        </div>
                        <div class="col">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname" required>
                            <span class="error text-danger" id="mnameError"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                            <span class="error text-danger" id="lnameError"></span>
                        </div>
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="error text-danger" id="passwordError"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="error text-danger" id="emailError"></span>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="update" id="regist" value="update" class="btn btn-primary">
                    </div>
                </form>
            </div><br>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>