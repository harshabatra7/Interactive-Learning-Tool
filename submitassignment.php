<?php
// Include header
include 'header.php';

// Include database connection
include 'db.php';

// Check if assignment ID is provided in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $assignment_id = $_GET['id'];

    // Fetch assignment details from the database
    $sql = "SELECT * FROM assignments WHERE id = $assignment_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $assignment_name = $row['assignment_name'];
        $deadline = $row['deadline'];

        // Check if the deadline has passed
        $deadline_passed = (strtotime($deadline) < time());
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Submit Assignment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Manage Assignments</a></li>
                        <li class="breadcrumb-item active">Submit Assignment</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Submit Assignment: <?php echo $assignment_name; ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if($deadline_passed) { ?>
                                <p>The deadline for this assignment has passed. You cannot submit it anymore.</p>
                            <?php } else { ?>
                                <!-- Form for submitting the assignment -->
                                <form action="submit_assignment_handler.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="assignmentFile">Select Assignment File</label>
                                        <input type="file" class="form-control" id="assignmentFile" name="assignmentFile" accept=".pdf" required>
                                    </div>
                                    <input type="hidden" name="assignmentId" value="<?php echo $assignment_id; ?>">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            <?php } ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
    } else {
        // Assignment not found
        echo "<div class='alert alert-danger'>Assignment not found.</div>";
    }
} else {
    // ID not provided in the URL
    echo "<div class='alert alert-danger'>Assignment ID not provided in the URL.</div>";
}

// Include footer
include 'footer.php';
?>
