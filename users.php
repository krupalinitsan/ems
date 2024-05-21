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
        $update_status_sql = "UPDATE users SET status='$status' WHERE id='$id'";
        mysqli_query($conn, $update_status_sql);
    }
    if ($type == 'delete') {
        $id = $_GET['id'];
        $role = $_SESSION['ROLE'];

        if ($role == 1) {
            $delete_sql = "DELETE FROM users WHERE id = '$id'";
            $message = "User hard deleted successfully!";
        } else {
            $delete_sql = "UPDATE users SET deleted = 1 WHERE id = '$id'";
            $message = "User soft deleted successfully!";
        }

        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['message'] = $message; // Set the message in session
        } else {
            $_SESSION['message'] = "Error deleting user: " . mysqli_error($conn);
        }

        header("Location: users.php"); // Redirect to the users page
        exit();

    }
}
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Users
        </div>
        <br>

        <div class="text-right px-4">
            <a href="add_user.php" class="btn btn-dark">ADD USERS</a>
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
                            <th>first name</th>
                            <th>Middle name</th>
                            <th>last name</th>
                            <th>email</th>
                            <th>role</th>
                            <th>team</th>
                            <th colspan="2">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM users";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['firstname']; ?></td>
                                <td><?php echo $row['middlename']; ?></td>
                                <td><?php echo $row['lastname']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php
                                $role_id = $row['role'];
                                $team_query = "SELECT name FROM roles WHERE id=?";
                                $team_stmt = $conn->prepare($team_query);
                                $team_stmt->bind_param("i", $role_id);
                                $team_stmt->execute();
                                $team_result = $team_stmt->get_result();
                                $team_row = $team_result->fetch_assoc();

                                if (is_null($team_row)) {
                                    echo "-";
                                } else {
                                    echo $team_row['name'];
                                }
                                ?></td>

                                <td>
                                    <?php
                                    $team_id = $row['team_id'];
                                    $team_query = "SELECT name FROM teams WHERE id=?";
                                    $team_stmt = $conn->prepare($team_query);
                                    $team_stmt->bind_param("i", $team_id);
                                    $team_stmt->execute();
                                    $team_result = $team_stmt->get_result();
                                    $team_row = $team_result->fetch_assoc();

                                    if (is_null($team_row)) {
                                        echo "-";
                                    } else {
                                        echo $team_row['name'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                    } else {
                                        echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                    }
                                    echo "<br>";
                                    // Edit button
                                    echo "<a href='manage_user.php?id=" . $row['id'] . "' class='btn btn-info' onclick='return confirmEdit()'>Edit</a>&nbsp;";
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

<!-- JavaScript for confirmation prompts -->
<script>
    function confirmEdit() {
        return confirm('Are you sure you want to edit this user?');
    }

    function confirmDelete() {
        return confirm('Are you sure you want to delete this user? This action cannot be undone.');
    }
</script>

<?php include ('footer.php'); ?>