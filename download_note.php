<?php
// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Escape user input for security
    $note_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch note data from the database
    $sql = "SELECT * FROM notes WHERE id = '$note_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch note details
        $row = $result->fetch_assoc();
        $file_name = $row['file_name'];
        $file_path = '../faculty/uploads/' . $file_name;

        // Check if file exists
        if (file_exists($file_path)) {
            // Set headers for file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            // File not found
            echo "File not found.";
        }
    } else {
        // Note not found
        echo "Note not found.";
    }
} else {
    // Invalid request
    echo "Invalid request.";
}

// Close database connection
$conn->close();
?>
