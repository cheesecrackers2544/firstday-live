<?php
session_start();

// Database credentials
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

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ListingID'])) {
        // Assume Title, Description, and Price are the fields you want to update
        $stmt = $conn->prepare("UPDATE listings SET Title = ?, Description = ?, Price = ? WHERE ListingID = ?");
        
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssdi", $_POST['Title'], $_POST['Description'], $_POST['Price'], $_POST['ListingID']);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Listing updated successfully.";
            // Redirect back to user-listings.php or to the updated listing page
            // header("Location: user-listings.php"); // Uncomment this line if redirection is required
        } else {
            echo "Error updating listing.";
        }
        $stmt->close();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "You must be logged in to update listings.";
}

$conn->close();
?>
