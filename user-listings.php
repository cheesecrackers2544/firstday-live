<?php
session_start(); // Start the session to access session variables

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

// Check if the user is logged in and has an OwnerID set
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['owner_id'])) {
    $ownerId = $_SESSION['owner_id'];

    $stmt = $conn->prepare("SELECT * FROM listings WHERE OwnerID = ?");
    $stmt->bind_param("i", $ownerId);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h1>Your Listings</h1>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='listing'>";
            echo "<h2>" . htmlspecialchars($row['Title']) . "</h2>";
            // ... include other details you wish to show ...
            echo "<a href='edit-listing.php?id=" . urlencode($row['ListingID']) . "'>Edit Listing</a>";
            echo "</div>";
        }
    } else {
        echo "No listings found for your account.";
    }

    $stmt->close();
} else {
    echo "You must be logged in to view this page.";
}

$conn->close();
?>