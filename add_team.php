<?php
include ('header.php');
require ("db.php");
$msg = "";

if (isset($_POST['add'])) {

    // Fetch $_POST values
    $tname = trim($_POST['tname']);

    // Validate input
    if (empty($tname)) {
        $msg = "Please enter a valid team name.";
    } else {
        // Insertion query
        $sql = "INSERT INTO teams (name) VALUES ('$tname')";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo '<script>alert("team inserted successfully."); 
            window.location.replace("team.php");</script>';
            exit();
        } else {
            $msg = "Error inserting team. Please try again.";
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
    <title>Add Team</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="text-center text-danger">
            <?php echo $msg; ?>
        </div>
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Add Team</div>
            <div class="card-body">
                <form id="registrationForm" method="post" action="" name="employeeForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="tname" class="form-label"> Name</label>
                            <input type="text" class="form-control" id="tname" name="tname" required>
                            <span class="error text-danger" id="fnameError"></span>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="add" id="regist" value="ADD TEAM" class="btn btn-primary">
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