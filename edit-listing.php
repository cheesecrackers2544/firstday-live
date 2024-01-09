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

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_GET['id'])) {
        $listingId = $_GET['id'];

        // Fetch the listing details for editing
        $stmt = $conn->prepare("SELECT * FROM listings WHERE ListingID = ?");
        $stmt->bind_param("i", $listingId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $listing = $result->fetch_assoc();
            
            // Form with the listing details for editing
            echo "<form action='update-listing.php' method='post'>";
            echo "<input type='hidden' name='ListingID' value='" . htmlspecialchars($listing['ListingID']) . "'>";
            
            // Title
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='Title' value='" . htmlspecialchars($listing['Title']) . "'><br>";

            // Description
            echo "<label for='description'>Description:</label>";
            echo "<textarea id='description' name='Description'>" . htmlspecialchars($listing['Description']) . "</textarea><br>";

            // Price
            echo "<label for='price'>Price:</label>";
            echo "<input type='number' id='price' name='Price' value='" . htmlspecialchars($listing['Price']) . "'><br>";

            // Telephone
            echo "<label for='telephone'>Telephone:</label>";
            echo "<input type='tel' id='telephone' name='Telephone' value='" . htmlspecialchars($listing['Telephone']) . "'><br>";

            // Email
            echo "<label for='email'>Email:</label>";
            echo "<input type='email' id='email' name='Email' value='" . htmlspecialchars($listing['Email']) . "'><br>";

            // Street Address
            echo "<label for='streetAddress'>Street Address:</label>";
            echo "<input type='text' id='streetAddress' name='StreetAddress' value='" . htmlspecialchars($listing['StreetAddress']) . "'><br>";

            // Suburb
            echo "<label for='suburb'>Suburb:</label>";
            echo "<input type='text' id='suburb' name='Suburb' value='" . htmlspecialchars($listing['Suburb']) . "'><br>";

            // Town/City
            echo "<label for='townCity'>Town/City:</label>";
            echo "<input type='text' id='townCity' name='TownCity' value='" . htmlspecialchars($listing['TownCity']) . "'><br>";

            // Service Type
            echo "<label for='serviceType'>Service Type:</label>";
            echo "<input type='text' id='serviceType' name='ServiceType' value='" . htmlspecialchars($listing['ServiceType']) . "'><br>";

            // Hours ECE
            echo "<label for='hoursECE'>Hours ECE:</label>";
            echo "<input type='number' id='hoursECE' name='HoursECE' value='" . htmlspecialchars($listing['HoursECE']) . "'><br>";

            // Area Unit
            echo "<label for='areaUnit'>Area Unit:</label>";
            echo "<input type='text' id='areaUnit' name='AreaUnit' value='" . htmlspecialchars($listing['AreaUnit']) . "'><br>";

            // Management Contact Name
            echo "<label for='managementContactName'>Management Contact Name:</label>";
            echo "<input type='text' id='managementContactName' name='ManagementContactName' value='" . htmlspecialchars($listing['ManagementContactName']) . "'><br>";

            // Management Contact Phone
            echo "<label for='managementContactPhone'>Management Contact Phone:</label>";
            echo "<input type='tel' id='managementContactPhone' name='ManagementContactPhone' value='" . htmlspecialchars($listing['ManagementContactPhone']) . "'><br>";

            // Latitude
            echo "<label for='latitude'>Latitude:</label>";
            echo "<input type='text' id='latitude' name='Latitude' value='" . htmlspecialchars($listing['Latitude']) . "'><br>";

            // Longitude
            echo "<label for='longitude'>Longitude:</label>";
            echo "<input type='text' id='longitude' name='Longitude' value='" . htmlspecialchars($listing['Longitude']) . "'><br>";

            // Max. Licensed Positions
            echo "<label for='maxLicensedPositions'>Max. Licensed Positions:</label>";
            echo "<input type='number' id='maxLicensedPositions' name='MaxLicensedPositions' value='" . htmlspecialchars($listing['MaxLicensedPositions']) . "'><br>";

            // Capacity Under 2s
            echo "<label for='capacityUnder2s'>Capacity Under 2s:</label>";
            echo "<input type='number' id='capacityUnder2s' name='CapacityUnder2s' value='" . htmlspecialchars($listing['CapacityUnder2s']) . "'><br>";

            echo "<input type='submit' value='Update Listing'>";
            echo "</form>";
        } else {
            echo "Listing not found.";
        }
        $stmt->close();
    } else {
        echo "No listing ID provided.";
    }
} else {
    echo "You must be logged in to edit listings.";
}

$conn->close();
?>
