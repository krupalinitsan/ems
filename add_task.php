<?php
require("db.php");
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
    // Fetch $_POST values
    $pname = $_POST['pname'];
    $description = $_POST['desc'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $deadline = $_POST['ddate'];
    $employee_id = $_POST['employee'];
    $project_id = $_POST['project'];

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
        $msg = "Task updated successfully";
    } else {
        $msg = "Please enter valid details: " . mysqli_error($conn);
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
                <form id="registrationForm" method="post" action="">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pname" name="pname" value="<?php echo htmlspecialchars($task_data['name']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc" value="<?php echo htmlspecialchars($task_data['description']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="employee" class="form-label">Employee</label>
                            <select id="employee" name="employee" class="form-control">
                                <?php
                                include("db.php");

                                // Query to fetch all users
                                $sql = "SELECT * FROM users";
                                $data = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $selected = ($task_data['employee_id'] == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
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
                            <input type="date" class="form-control" id="ddate" name="ddate" value="<?php echo htmlspecialchars($task_data['deadline']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sdate" name="sdate" value="<?php echo htmlspecialchars($task_data['start_date']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edate" name="edate" value="<?php echo htmlspecialchars($task_data['end_date']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="update" id="regist" value="Update Task" class="btn btn-primary">
                    </div>
                    <?php echo $msg; ?>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
