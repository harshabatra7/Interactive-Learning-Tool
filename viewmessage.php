<?php
// Include header
include 'header.php';

// Include database connection
include 'db.php';

// Fetch received messages data from the database
$sql = "SELECT * FROM messages WHERE student_id = '$sessionname'";
$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Received Messages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Received Messages</li>
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
                            <h3 class="card-title">Received Messages Data Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="receivedMessagesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Faculty Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Received At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["tid"] . "</td>";
                                            echo "<td>" . $row["message_subject"] . "</td>";
                                            echo "<td>" . $row["message_body"] . "</td>";
                                            echo "<td>" . $row["sent_at"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No received messages found</td></tr>";
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
