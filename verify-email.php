<?php
//verify email.php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Placeholder for database connection code
    $host = '127.0.0.1'; // or your host
    $dbUsername = 'root'; // or your db username
    $dbPassword = ''; // or your db password
    $dbName = 'firstdaydb'; // your database name

    // Establishing database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify the token
    $stmt = $conn->prepare("SELECT OwnerID FROM Owner_Profiles WHERE VerificationToken = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Token is valid. Update the EmailVerified field.
        $updateStmt = $conn->prepare("UPDATE Owner_Profiles SET EmailVerified = TRUE, VerificationToken = NULL WHERE VerificationToken = ?");
        $updateStmt->bind_param("s", $token);
        $updateStmt->execute();
        $updateStmt->close();

        echo "Email verification successful!";
    } else {
        echo "Invalid or expired verification link.";
    }

    $stmt->close();
    $conn->close();
}
?>
