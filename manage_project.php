<div?php

require ("db.php");
$msg = "";
$id = $_GET['id'];
$sql = "SELECT * FROM projects WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (isset($_POST['add'])) {

    //fetch $_post values 
    $pname = $_POST['pname'];
    $description = $_POST['desc'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $deadline = $_POST['ddate'];

    $sql = "INSERT INTO projects (name, description, start_date, end_date, deadline )
    VALUES ('$pname','$description' ,'$sdate','$edate','$deadline')";
    $data = mysqli_query($conn, $sql);

    if ($data) {

        $msg = "project updated sucessfully";
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
            <div class="card-header">Add Project</div>
            < class="card-body">
                <form  method="post" action="" name="projectForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label"> Name</label>
                            <input type="text" class="form-control" id="pname" value="<?php echo $row['name'] ?>"
                                name="pname" required>
                        </div>
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="desc" value="<?php echo $row['description'] ?>"
                                name="desc" required>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sdate" name="sdate" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edate" name="edate" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="ddate" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="ddate" name="ddate" required>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="add" id="regist" value="ADD PROJECT" class="btn btn-primary">
                    </div>
                    <div color="red">
                    <?php echo $msg; ?>
</div>
                </form>
            </><br>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </script>
</body>

</html>