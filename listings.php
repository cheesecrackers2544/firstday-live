<?php
// a list of all the listings in the database, filtered by status 'Accepted'
// Database credentials
$host = '127.0.0.1'; // or your host, could also be 'localhost'
$dbUsername = 'root'; // or your db username
$dbPassword = ''; // or your db password
$dbName = 'firstdaydb'; // your database name

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all listings where status is 'Accepted'
$sql = "SELECT ListingID, Title FROM listings WHERE status = 'Accepted'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='listing'>";
        echo "<h2>" . htmlspecialchars($row['Title']) . "</h2>";
        // Create a link to the individual listing page with the ListingID as a URL parameter
        echo "<a href='listing.php?id=" . $row['ListingID'] . "'>View Listing</a>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
