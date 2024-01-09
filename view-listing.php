<?php
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

// Check if the 'id' GET parameter is set
if (isset($_GET['id'])) {
    $listingId = $conn->real_escape_string($_GET['id']); // Always sanitize user input

    // SQL query to select the listing with the given ID
    $stmt = $conn->prepare("SELECT * FROM listings WHERE ListingID = ?");
    $stmt->bind_param("i", $listingId); // 'i' indicates the parameter type is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();
        // Output the details of the listing
        echo "<div class='listing-details'>";
        echo "<h1>" . (empty($row['Title']) ? 'Not Available' : htmlspecialchars($row['Title'])) . "</h1>";
        echo "<p>Description: " . (empty($row['Description']) ? 'Not Available' : nl2br(htmlspecialchars($row['Description']))) . "</p>";
        echo "<p>Price: " . (empty($row['Price']) ? 'Not Available' : htmlspecialchars($row['Price'])) . "</p>";
        echo "<p>Telephone: " . (empty($row['Telephone']) ? 'Not Available' : htmlspecialchars($row['Telephone'])) . "</p>";
        echo "<p>Email: " . (empty($row['Email']) ? 'Not Available' : "<a href='mailto:" . htmlspecialchars($row['Email']) . "'>" . htmlspecialchars($row['Email']) . "</a>") . "</p>";
        echo "<p>Street Address: " . (empty($row['StreetAddress']) ? 'Not Available' : htmlspecialchars($row['StreetAddress'])) . "</p>";
        echo "<p>Suburb: " . (empty($row['Suburb']) ? 'Not Available' : htmlspecialchars($row['Suburb'])) . "</p>";
        echo "<p>Town/City: " . (empty($row['TownCity']) ? 'Not Available' : htmlspecialchars($row['TownCity'])) . "</p>";
        echo "<p>Service Type: " . (empty($row['ServiceType']) ? 'Not Available' : htmlspecialchars($row['ServiceType'])) . "</p>";
        echo "<p>Hours ECE: " . (empty($row['HoursECE']) ? 'Not Available' : htmlspecialchars($row['HoursECE'])) . "</p>";
        echo "<p>Area Unit: " . (empty($row['AreaUnit']) ? 'Not Available' : htmlspecialchars($row['AreaUnit'])) . "</p>";
        echo "<p>Management: " . (empty($row['Management']) ? 'Not Available' : htmlspecialchars($row['Management'])) . "</p>";
        echo "<p>Latitude: " . (empty($row['Latitude']) ? 'Not Available' : htmlspecialchars($row['Latitude'])) . "</p>";
        echo "<p>Longitude: " . (empty($row['Longitude']) ? 'Not Available' : htmlspecialchars($row['Longitude'])) . "</p>";
        echo "<p>Max Licensed Positions: " . (empty($row['MaxLicensed']) ? 'Not Available' : htmlspecialchars($row['MaxLicensed'])) . "</p>";
        echo "<p>Capacity Under 2s: " . (empty($row['CapacityUnder2']) ? 'Not Available' : htmlspecialchars($row['CapacityUnder2'])) . "</p>";

        if (empty($row['OwnerID'])) {
            echo "<p><a href='claim-listing.php?id=" . $listingId . "'>Claim this Listing</a></p>";
        
        }

        echo "</div>";
    } else {
        echo "Listing not found.";
    }

    $stmt->close();
} else {
    echo "No listing ID provided.";
}

// Close connection
$conn->close();
?>
