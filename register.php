<?php

require ("db.php");
$msg = "";
if (isset($_POST['regist'])) {

    //fetch $_post values 
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    // $password = md5($_POST['password']);
    $password = $_POST['password'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users ( firstname, middlename, lastname,pass, email) VALUES ('$fname',' $mname',' $lname','$password',' $email')";
    $data = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($data);
    if ($data) {

        $msg = "data inserted sucessfully";
        header("location: login.php");
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
    <title>Admin - Register</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Add User</div>
            <div class="card-body">
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
                        <input type="submit" name="regist" id="regist" value="Register" class="btn btn-primary">
                    </div>
                    <div class="mb-3" align="center">
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </form>
            </div><br>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- java script form validation -->
    <script>
        function validateForm() {
            var fname = document.forms["employeeForm"]["fname"].value;
            var mname = document.forms["employeeForm"]["mname"].value;
            var lname = document.forms["employeeForm"]["lname"].value;
            var password = document.forms["employeeForm"]["password"].value;
            var email = document.forms["employeeForm"]["email"].value;

            var isValid = true;

            // First Name validation
            if (fname == "" || fname.length < 5) {
                document.getElementById("fnameError").innerHTML = "First name must be at least 5 characters.";
                isValid = false;
            } else {
                document.getElementById("fnameError").innerHTML = "";
            }

            // Middle Name validation
            if (mname == "" || mname.length < 5) {
                document.getElementById("mnameError").innerHTML = "Middle name must be at least 5 characters.";
                isValid = false;
            } else {
                document.getElementById("mnameError").innerHTML = "";
            }

            // Last Name validation
            if (lname == "" || lname.length < 5) {
                document.getElementById("lnameError").innerHTML = "Last name must be at least 5 characters.";
                isValid = false;
            } else {
                document.getElementById("lnameError").innerHTML = "";
            }

            // Email validation
            if (email == "") {
                document.getElementById("emailError").innerHTML = "Email is required.";
                isValid = false;
            } else {
                document.getElementById("emailError").innerHTML = "";
            }

            // Password validation
            var uppercaseRegex = /[A-Z]/;
            var lowercaseRegex = /[a-z]/;
            if (password == "" || !uppercaseRegex.test(password) || !lowercaseRegex.test(password) || password.length < 6) {
                document.getElementById("passwordError").innerHTML = "Password must contain at least one uppercase letter, one lowercase letter, and be at least 6 characters long.";
                isValid = false;
            } else {
                document.getElementById("passwordError").innerHTML = "";
            }

            return isValid;
        }
    </script>
</body>

</html>