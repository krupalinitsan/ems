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

        <!-- Search form -->
        <form method="GET" action="users.php" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" style="margin: 20px;" type="search" placeholder="Search"
                aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

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
                        $limit = 5;
                        $search = '';
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                        }

                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        $query = "SELECT * FROM users WHERE 
                                  firstname LIKE '%$search%' OR
                                  middlename LIKE '%$search%' OR
                                  lastname LIKE '%$search%' OR
                                  email LIKE '%$search%' 
                                  ORDER BY id DESC LIMIT {$offset},{$limit}";
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
                                $role_query = "SELECT name FROM roles WHERE id=?";
                                $role_stmt = $conn->prepare($role_query);
                                $role_stmt->bind_param("i", $role_id);
                                $role_stmt->execute();
                                $role_result = $role_stmt->get_result();
                                $role_row = $role_result->fetch_assoc();

                                echo is_null($role_row) ? "-" : $role_row['name'];
                                ?>
                                </td>
                                <td><?php
                                $team_id = $row['team_id'];
                                $team_query = "SELECT name FROM teams WHERE id=?";
                                $team_stmt = $conn->prepare($team_query);
                                $team_stmt->bind_param("i", $team_id);
                                $team_stmt->execute();
                                $team_result = $team_stmt->get_result();
                                $team_row = $team_result->fetch_assoc();

                                echo is_null($team_row) ? "-" : $team_row['name'];
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
                <?php
                $sql = "SELECT * FROM users WHERE 
                        firstname LIKE '%$search%' OR
                        middlename LIKE '%$search%' OR
                        lastname LIKE '%$search%' OR
                        email LIKE '%$search%'";
                $data = mysqli_query($conn, $sql);

                if (mysqli_num_rows($data) > 0) {
                    $total_record = mysqli_num_rows($data);
                    $total_page = ceil($total_record / $limit);

                    echo '<ul class="pagination justify-content-center">';
                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . ($page - 1) . '&search=' . $search . '">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . ($page + 1) . '&search=' . $search . '">Next</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
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