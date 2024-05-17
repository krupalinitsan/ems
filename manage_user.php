<?php

require ("db.php");
$msg = "";
if (isset($_POST['add'])) {

    //fetch $_post values 
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    // $password = md5($_POST['password']);
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $team = $_POST['team'];

    $sql = "INSERT INTO users ( firstname, middlename, lastname,pass, email ,role,team_id) VALUES ('$fname',' $mname',' $lname','$password',' $email' ,'$role','$team')";
    $data = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($data);
    if ($data) {

        $msg = "data inserted sucessfully";
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
    <title>Add user</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Add user</div>
            <div class="card-body">
                <form id="registrationForm" method="post" action="" name="employeeForm">
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
                    <div class="row mb-3">
                        <div class="col">
                            <label for="role" class="form-label">User Role</label>
                            <select name="role">
                                <option value="1">Project Manager</option>
                                <option value="2">Team Leader</option>
                                <option value="3">Employee</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="role" class="form-label">Select Team</label>
                            <select name="team">
                                <option value="1">Font end</option>
                                <option value="2">Back end</option>
                                <option value="3">HR Team</option>
                                <option value="4">Q/A</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="add" id="regist" value="ADD USER" class="btn btn-primary">
                    </div>
                    <?php echo $msg; ?>
                </form>
            </div><br>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </script>
</body>

</html>