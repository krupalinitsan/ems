<?php

require ("db.php");
$msg = "";
$id = $_GET['id'];
if (isset($_POST['edit'])) {

    //fetch $_post values 
    $tname = $_POST['tname'];
    // insertion query 
    $sql = "UPDATE teams SET name='$tname' WHERE id='$id' ";
    $data = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($data);
    if ($data) {

        $msg = "team updated sucessfully";
        // header("location: team.php");
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

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">EDIT TEAM</div>
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
                        <input type="submit" name="edit" id="edit" value="EDIT TEAMS" class="btn btn-primary">
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