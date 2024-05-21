<?php
// Include header
include 'header.php';

// Include database connection
include 'db.php';

// Fetch assignment data from the database
$sql = "SELECT assignments.*, submissions.id AS submission_id FROM assignments LEFT JOIN submissions ON assignments.id = submissions.assignment_id AND submissions.user_email = '$sessionemail' WHERE assignments.department='$sessiondept' AND assignments.class='$sessionyear' AND assignments.section='$sessionsec'";
$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Assignments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Assignments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assignment Data Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="assignmentTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Assignment Name</th>
                                        <th>Faculty Email</th>
                                        <th>Deadline</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr";
                                            if (strtotime($row['deadline']) < strtotime(date('Y-m-d H:i:s'))) {
                                                echo " style='background-color: #f8d7da;'";
                                                echo ">";
                                                echo "<td>" . $row["assignment_name"] . "</td>";
                                                echo "<td>" . $row["tid"] . "</td>";
                                                echo "<td>" . $row["deadline"] . "</td>";
                                                echo "<td>" . $row["description"] . "</td>";
                                                echo "<td>Deadline Crossed</td>";
                                                echo "</tr>";
                                                continue; // Skip the rest of the loop for this assignment
                                            }
                                            
                                            echo ">";
                                            echo "<td>" . $row["assignment_name"] . "</td>";
                                            echo "<td>" . $row["tid"] . "</td>";
                                            echo "<td>" . $row["deadline"] . "</td>";
                                            echo "<td>" . $row["description"] . "</td>";
                                            
                                            if ($row["submission_id"]) {
                                                echo "<td>Assignment Submitted</td>";
                                            } else {
                                                echo "<td><a href='compiler.php?id=" . $row['id'] . "' target='_blank' class='btn btn-warning'>Open Compiler</a><br><a href='submitassignment.php?id=" . $row['id'] . "' class='btn btn-success'>Submit Assignment</a></td>";
                                            }
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No assignment data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->


            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include footer
include 'footer.php';
?>
