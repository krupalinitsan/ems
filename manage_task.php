<?php
include ('header.php');
require ("db.php");

$msg = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Fetch the current task data
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $task_data = mysqli_fetch_assoc($result);
    } else {
        echo "No task found with ID $id";
        exit;
    }
} else {
    echo "Invalid task ID";
    exit;
}

// Handle form submission to update task data
if (isset($_POST['update'])) {
    // Validate and sanitize user input
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $description = mysqli_real_escape_string($conn, $_POST['desc']);
    $sdate = mysqli_real_escape_string($conn, $_POST['sdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['edate']);
    $deadline = mysqli_real_escape_string($conn, $_POST['ddate']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee']);
    $project_id = mysqli_real_escape_string($conn, $_POST['project']);

    // Check if all fields are filled
    if (!empty($pname) && !empty($description) && !empty($sdate) && !empty($edate) && !empty($deadline) && !empty($employee_id) && !empty($project_id)) {
        // SQL query to update data in the tasks table
        $sql = "UPDATE tasks SET 
                name = '$pname', 
                description = '$description', 
                employee_id = '$employee_id', 
                project_id = '$project_id', 
                deadline = '$deadline', 
                start_date = '$sdate', 
                end_date = '$edate' 
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("task updated successfully."); 
            window.location.replace("task.php");</script>';
            exit();

        } else {
            $msg = "Please enter valid details: " . mysqli_error($conn);
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
    <title>Update Task</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Update Task</div>
            <div class="card-body">
                <div style="color: red;"><?php echo $msg; ?></div>
                <form id="registrationForm" method="post" name="projectForm" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pname" name="pname"
                                value="<?php echo htmlspecialchars($task_data['name']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc"
                                value="<?php echo htmlspecialchars($task_data['description']); ?>" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="employee" class="form-label">Employee</label>
                            <select id="employee" name="employee" class="form-control">
                                <?php
                                include ("db.php");

                                // Query to fetch all users
                                $sql = "SELECT * FROM users";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $selected = ($task_data['employee_id'] == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['firstname'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No employees found</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="project" class="form-label">Project</label>
                            <select id="project" name="project" class="form-control" required>
                                <?php
                                $sql = "SELECT * FROM projects";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $selected = ($task_data['project_id'] == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No projects found</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="ddate" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="ddate" name="ddate"
                                value="<?php echo htmlspecialchars($task_data['deadline']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sdate" name="sdate"
                                value="<?php echo htmlspecialchars($task_data['start_date']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edate" name="edate"
                                value="<?php echo htmlspecialchars($task_data['end_date']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="update" id="regist" value="Update Task" class="btn btn-primary">
                    </div>
                    <div style="color: red;"><?php echo $msg; ?></div>
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