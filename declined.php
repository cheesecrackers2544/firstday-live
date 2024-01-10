<?php
// Include necessary database connection code or configuration
$host = '127.0.0.1'; // or your host
$dbUsername = 'root'; // or your db username
$dbPassword = ''; // or your db password
$dbName = 'firstdaydb'; // your database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a listing ID is provided via GET parameter
if (isset($_GET['id'])) {
    $listingId = $_GET['id'];

    // Perform a database update to mark the listing as declined (you should have a column for status)
    // Example query (make sure to replace with your actual table and column names):
    $updateQuery = "UPDATE listings SET status = 'Declined' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $listingId);
    
    if ($stmt->execute()) {
        // Redirect to a success page or wherever you want
        header("Location: success.html");
    } else {
        echo "Error updating the listing status: " . $conn->error;
    }
} else {
    // Handle the case where no ID is provided
    echo "Invalid request.";
}

$conn->close();
?>
