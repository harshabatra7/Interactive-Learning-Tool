<?php
session_start();
// Include database connection
include 'db.php';

$sessionemail = $_SESSION['email'];
$sessionname = $_SESSION['name'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['assignmentId']) && isset($_FILES['assignmentFile'])) {
        // Escape user inputs for security
        $assignment_id = mysqli_real_escape_string($conn, $_POST['assignmentId']);
        
        // Get user email and name from session variables
        $user_email = $sessionemail;
        $user_name = $sessionname;

        // File upload handling
        $target_dir = "assignment_submissions/"; // Specify the directory where you want to save the assignment files
        $file_name = uniqid() . "_" . basename($_FILES["assignmentFile"]["name"]); // Generate unique filename
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Allow certain file formats (Only allowing PDF files)
        if($fileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["assignmentFile"]["tmp_name"], $target_file)) {
                // File uploaded successfully, now insert data into database
                $sql = "INSERT INTO submissions (assignment_id, file_name, user_email, user_name) VALUES ('$assignment_id', '$file_name', '$user_email', '$user_name')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>
alert('Assignment submitted successfully.');
window.location.href='viewassignment.php';
</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

// Close database connection
$conn->close();
?>
