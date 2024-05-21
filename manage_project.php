<?php
include ('header.php');
require ("db.php");

$msg = "";
$id = $_GET['id'];
$sql = "SELECT * FROM projects WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    // Validate and sanitize user input
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $description = mysqli_real_escape_string($conn, $_POST['desc']);
    $sdate = mysqli_real_escape_string($conn, $_POST['sdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['edate']);
    $deadline = mysqli_real_escape_string($conn, $_POST['ddate']);

    // Check if all fields are filled
    if (!empty($pname) && !empty($description) && !empty($sdate) && !empty($edate) && !empty($deadline)) {
        // Update the project in the database
        $sql = "UPDATE projects 
                SET name='$pname', description='$description', start_date='$sdate', end_date='$edate', deadline='$deadline'
                WHERE id='$id'";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo '<script>alert("project updated successfully."); 
            window.location.replace("project.php");</script>';
            exit();
        } else {
            $msg = "Failed to update project. Please try again.";
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
    <title>Edit Project</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Edit Project</div>
            <div class="card-body">
                <div style="color: red;"><?php echo $msg; ?></div>
                <form method="post" name="projectForm" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pname" value="<?php echo $row['name'] ?>"
                                name="pname" required>
                        </div>
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc"
                                value="<?php echo $row['description'] ?>" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="sdate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="sdate" name="sdate"
                        value="<?php echo $row['start_date'] ?>" required>
                </div>
                <div class="col">
                    <label for="edate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="edate" name="edate"
                        value="<?php echo $row['end_date'] ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="ddate" class="form-label">Deadline</label>
                    <input type="date" class="form-control" id="ddate" name="ddate"
                        value="<?php echo $row['deadline'] ?>" required>
                </div>
            </div>
            <div class="mb-3" align="center">
                <input type="submit" name="update" id="update" value="UPDATE PROJECT" class="btn btn-primary">
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
            if (new Date(edate) >= new Date(ddate) && new Date(ddate) > Date(sdate)) {
                alert('End date cannot be after deadline or same.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<?php include ('footer.php'); ?>