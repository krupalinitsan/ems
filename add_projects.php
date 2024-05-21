<?php
include ('header.php');
require ("db.php");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Fetch and sanitize $_POST values
    $pname = $_POST['pname'];
    $description = $_POST['desc'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $deadline = $_POST['ddate'];

    // Simple validation for dates
    if (strtotime($sdate) > strtotime($edate)) {
        $msg = "Start date cannot be after end date.";
    } elseif (strtotime($edate) > strtotime($deadline)) {
        $msg = "End date cannot be after deadline.";
    } else {
        // Insert into the database
        $sql = "INSERT INTO projects (name, description, start_date, end_date, deadline)
                VALUES ('$pname', '$description', '$sdate', '$edate', '$deadline')";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo '<script>alert("project inserted successfully."); 
            window.location.replace("project.php");</script>';
            exit();
        } else {
            $msg = "Error: " . mysqli_error($conn);
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
    <title>Add Project</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Add Project</div>
            <div class="text-center text-danger">
                <?php echo $msg; ?>
            </div>
            <div class="card-body">
                <form id="registrationForm" method="post" action="" name="projectForm" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pname" name="pname" required>
                        </div>
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc" required></textarea>
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
                        <input type="submit" name="add" id="add" value="ADD PROJECT" class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const sdate = document.getElementById('sdate').value;
            const edate = document.getElementById('edate').value;
            const ddate = document.getElementById('ddate').value;

            if (new Date(sdate) >= new Date(edate)) {
                alert('Start date cannot be after end date or same.');
                return false;
            }
            if (new Date(edate) > new Date(ddate) && new Date(ddate) > Date(sdate)) {
                alert('End date cannot be after deadline.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<?php include ('footer.php'); ?>