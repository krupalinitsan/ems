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
        $update_status_sql = "update projects set status='$status' where id='$id'";
        mysqli_query($conn, $update_status_sql);
    }
    if ($type == 'delete') {
        $id = $_GET['id'];
        $delete_sql = "delete from projects where id='$id'";
        mysqli_query($conn, $delete_sql);
    }
}
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Projects
        </div>
        <br>
        <!-- <button class="btn btn-dark" style="align: right;"><a href="add_projects.php">ADD PROJECT</a></button> -->

        <div class="text-right px-4">
            <a href="add_projects.php" class="btn btn-dark">ADD PROJECT</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>project name</th>
                            <th>description</th>
                            <th>start date</th>
                            <th>end date</th>
                            <th>deadline</th>
                            <th colspan="2">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM projects";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
                                <td><?php echo $row['deadline']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "<span class='badge badge-complete' ><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                    } else {
                                        echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                    }
                                    echo "<span class='badge badge-edit'><a href='manage_project.php?id=" . $row['id'] . "'>Edit</a></span>&nbsp;";

                                    echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Delete</a></span>";

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
<?php include ('footer.php'); ?>