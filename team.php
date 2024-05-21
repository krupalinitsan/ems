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
        $update_status_sql = "update teams set status='$status' where id='$id'";
        mysqli_query($conn, $update_status_sql);
    }
    // Execute the delete query
    $role = $_SESSION['ROLE'];
    if ($type == 'delete') {
        $id = $_GET['id'];

        // Check if the role is admin (assuming $role is defined elsewhere in your code)
        if ($role == 1) {
            $delete_sql = "DELETE FROM teams WHERE id = '$id'";
            $message = "Team hard deleted successfully!";
            // Soft delete query to update the 'deleted' column

        } else {
            // Hard delete query to remove the task from the database
            $delete_sql = "UPDATE teams SET deleted = 1 WHERE id = '$id'";
            $message = "Team soft deleted successfully!";
        }

        // Execute the delete query
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['message'] = $message; // Set the message in session
        } else {
            $_SESSION['message'] = "Error deleting user: " . mysqli_error($conn);
        }

        header("Location: team.php"); // Redirect to the users page
        exit();

    }
}

?>
<script>


</script>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Teams
        </div>
        <br>
        <div class="text-right px-4">
            <a href="add_team.php" class="btn btn-dark">ADD TEAM</a>
        </div>
        <!-- <button class="btn btn-dark"><a href="add_team.php">ADD TEAM</a></button> -->
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
                            <th>team name</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM teams";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                    } else {
                                        echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                    }
                                    echo "<br>";
                                    // Edit button
                                    echo "<a href='manage_team.php?id=" . $row['id'] . "' class='btn btn-info' onclick='return confirmEdit()'>Edit</a>&nbsp;";
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