<?php
require ("db.php");
$msg = "";

// Fetch user details if ID is provided
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!empty($id)) {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    // Validate and sanitize user input
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    // $password = $_POST['password'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = intval($_POST['role']);
    $team = intval($_POST['team']);

    // Check if all fields are filled
    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($role) && !empty($team)) {
        // Update the user in the database
        $sql = "UPDATE users 
                SET firstname='$fname', middlename='$mname', lastname='$lname', email='$email', role='$role', team_id='$team'
                WHERE id='$id'";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo '<script>alert("Data updated successfully."); 
            window.location.replace("users.php");</script>';
            exit();
        } else {
            $msg = "Failed to update user. Please try again.";
        }
    } else {
        $msg = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit user</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Edit user</div>
            <div style="color: red;"><?php echo $msg; ?></div>
            <div class="card-body">

                <form id="registrationForm" method="post" action="" name="employeeForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname"
                                value="<?php echo isset($row['firstname']) ? $row['firstname'] : ''; ?>" required>
                        </div>
                        <div class="col">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname"
                                value="<?php echo isset($row['middlename']) ? $row['middlename'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname"
                                value="<?php echo isset($row['lastname']) ? $row['lastname'] : ''; ?>" required>
                        </div>
                        <!-- <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div> -->
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="role" class="form-label">User Role</label>
                            <select name="role" class="form-control" required>
                                <?php
                                include ("db.php");

                                $sql = "SELECT * FROM roles";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No employees found</option>";
                                }

                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="team" class="form-label">Select Team</label>
                            <select name="team" class="form-control" required>
                                <?php
                                include ("db.php");

                                $sql = "SELECT * FROM teams";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No employees found</option>";
                                }

                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="update" id="update" value="UPDATE USER" class="btn btn-primary">
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
<?php include ('footer.php'); ?>