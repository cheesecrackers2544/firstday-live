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

    // Update query to set the listing as accepted
    $query = "UPDATE listings SET status = 'accepted' WHERE ListingId = $listingId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        echo "Listing has been accepted successfully.";

        // Query to get owner's email
        $emailQuery = "SELECT OwnerEmail FROM owner_profiles WHERE ListingId = $listingId";
        $result = $conn->query($emailQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ownerEmail = $row['OwnerEmail'];

            // Send email using PHPMailer
            $mail = new PHPMailer(true);

            try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jackbunckenburg@gmail.com'; // SMTP username
            $mail->Password = 'qzff rguu ahvk uaaf'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

                // Set recipient
                $mail->addAddress($ownerEmail);

                $mail->Subject = 'Your Listing Has Been Accepted';
                $mail->Body = "Your listing has been accepted.<br><br>";

                $mail->send();
                echo 'Email has been sent to the listing owner';
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            echo "Owner's email not found.";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No listing specified to accept.";
}

// Close the connection
$conn->close();
?>
