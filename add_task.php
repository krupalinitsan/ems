<?php
include ('header.php');
require ("db.php");
$msg = "";

// Check if the form is submitted
if (isset($_POST['add'])) {

    // Fetch $_POST values
    $pname = $_POST['pname'];
    $description = $_POST['desc'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $deadline = $_POST['ddate'];
    $employee_id = $_POST['employee'];
    $project_id = $_POST['project'];

    // Validate the input data
    if (empty($pname) || empty($description) || empty($sdate) || empty($edate) || empty($deadline) || empty($employee_id) || empty($project_id)) {
        $msg = "Please fill in all fields.";
    } elseif ($sdate > $edate) {
        $msg = "Start date cannot be later than end date.";
    } elseif ($deadline < $sdate) {
        $msg = "Deadline cannot be before the start date.";
    } else {
        // SQL query to insert data into the tasks table
        $sql = "INSERT INTO tasks (name, description, employee_id, project_id, deadline, start_date, end_date)
                VALUES ('$pname', '$description', '$employee_id', '$project_id', '$deadline', '$sdate', '$edate')";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo '<script>alert("task inserted successfully."); 
            window.location.replace("task.php");</script>';
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
    <title>Add Task</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Add Task</div>
            <div class="card-body">
                <div class="alert">
                    <?php echo $msg; ?>
                </div>
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
                            <label for="employee" class="form-label">Employee</label>
                            <select id="employee" name="employee" class="form-control" required>
                                <?php
                                include ("db.php");

                                $sql = "SELECT * FROM users";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['firstname'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No employees found</option>";
                                }

                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="project" class="form-label">Project</label>
                            <select id="project" name="project" class="form-control" required>
                                <?php
                                include ("db.php");

                                $sql = "SELECT * FROM projects";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No projects found</option>";
                                }

                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="ddate" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="ddate" name="ddate" required>
                        </div>
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sdate" name="sdate" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edate" name="edate" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="add" id="regist" value="ADD TASK" class="btn btn-primary">
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