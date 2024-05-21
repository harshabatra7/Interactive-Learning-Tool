<?php
// Include header
include 'header.php';

// Include database connection
include 'db.php';

// Fetch notes data from the database
$sql = "SELECT * FROM notes WHERE dept = '$sessiondept' AND class = '$sessionyear' AND section = '$sessionsec'";
$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Notes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Notes</li>
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
                            <h3 class="card-title">Notes Data Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="notesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Note Title</th>
                                        <th>Uploaded By</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["note_title"] . "</td>";
                                            echo "<td>" . $row["tid"] . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo "<td><a href='download_note.php?id=" . $row['id'] . "' class='btn btn-primary'>Download</a></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No notes found</td></tr>";
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
