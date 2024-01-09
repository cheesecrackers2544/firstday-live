<?php
//search.php
// Database connection details
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'firstdaydb');

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the search query is set
if (isset($_GET['query'])) {
    $searchTerm = $conn->real_escape_string($_GET['query']);

    // SQL query to search the TownCity field in the Listings table
    $sql = "SELECT * FROM listings WHERE TownCity LIKE '%$searchTerm%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<p>Title: " . htmlspecialchars($row['Title']) . "<br>";
            echo "Phone: " . htmlspecialchars($row['Telephone']) . "<br>";
            echo "Email: " . htmlspecialchars($row['Email']) . "<br>";
            echo "Street Address: " . htmlspecialchars($row['StreetAddress']) . "<br>";
            echo "Town / City: " . htmlspecialchars($row['TownCity']) . "<br>";
            echo "<a href='view-listing.php?id=" . urlencode($row['ListingID']) . "'>View Listing</a></p>";
        }
    } else {
        echo "No results found.";
    }
} else {
    echo "No search term provided.";
}

// Close the database connection
$conn->close();
?>
