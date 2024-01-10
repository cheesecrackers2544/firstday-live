<?php
// Connection credentials should be in a separate configuration file
$host = '127.0.0.1';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'firstdaydb';

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' GET parameter is set
if (isset($_GET['id'])) {
    $listingId = $_GET['id'];

    // Sanitize the input
    $listingId = $conn->real_escape_string($listingId);

    // Update query to set the listing as declined
    $query = "UPDATE listings SET status = 'declined' WHERE ListingId = $listingId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        echo "Listing has been declined successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No listing specified to decline.";
}

// Close the connection
$conn->close();
?>

