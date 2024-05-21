<?php
require_once ("db.php");
include ('header.php');
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = $_GET['type'];
    if ($type == 'status') {
        $operation = $_GET['operation'];
        $id = $_GET['id'];
        if ($operation == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        $update_status_sql = "update tasks set status='$status' where id='$id'";
        mysqli_query($conn, $update_status_sql);
    }
    $role = $_SESSION['ROLE'];
    if ($type == 'delete') {
        $id = $_GET['id'];

        // Check if the role is admin 
        if ($role == 1) {
            $delete_sql = "DELETE FROM tasks WHERE id = '$id'";
            $message = "Task hard deleted successfully!";
            // Soft delete query to update the 'deleted' column

        } else {
            // Hard delete query to remove the task from the database
            $delete_sql = "UPDATE tasks SET deleted = 1 WHERE id = '$id'";
            $message = "Task soft deleted successfully!";
        }

        // Execute the delete query
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['message'] = $message; // Set the message in session
        } else {
            $_SESSION['message'] = "Error deleting user: " . mysqli_error($conn);
        }

        header("Location: project.php"); // Redirect to the users page
        exit();

    }
}
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            tasks
        </div>
        <br>
        <!-- <button class="btn btn-dark" style="align: right;"><a href="add_projects.php">ADD PROJECT</a></button> -->

        <div class="text-right px-4">
            <a href="add_task.php" class="btn btn-dark">ADD TASK</a>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']); // Clear the message after displaying it
            }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>description</th>
                            <th>employee</th>
                            <th>project</th>
                            <th>deadline</th>
                            <th>start date</th>
                            <th>end date</th>
                            <th colspan="2">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM tasks";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php
                                $id = $row['employee_id'];
                                $sql = "SELECT firstname FROM users WHERE id='$id' ";
                                $data = mysqli_query($conn, $sql);
                                $employee = mysqli_fetch_assoc($data);
                                if (is_null($employee)) {
                                    echo "-";
                                } else {
                                    echo $employee['firstname'];
                                }

                                ?></td>
                                <td><?php
                                $id = $row['project_id'];

                                $sql = "SELECT name FROM projects WHERE id='$id' ";
                                $data = mysqli_query($conn, $sql);
                                $employee = mysqli_fetch_assoc($data);
                                if (is_null($employee)) {
                                    echo "-";
                                } else {
                                    echo $employee['name'];
                                }

                                ?></td>
                                <td><?php echo $row['deadline']; ?></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>


                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                    } else {
                                        echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                    }
                                    echo "<br>";
                                    // Edit button
                                    echo "<a href='manage_task.php?id=" . $row['id'] . "' class='btn btn-info' onclick='return confirmEdit()'>Edit</a>&nbsp;";
                                    // Delete button
                                    echo "<a href='?type=delete&id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirmDelete()'>Delete</a>";
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    function confirmEdit() {
        return confirm('Are you sure you want to edit this user?');
    }

    function confirmDelete() {
        return confirm('Are you sure you want to delete this user? This action cannot be undone.');
    }
</script>

<?php include ('footer.php'); ?>