<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\Exception.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\PHPMailer.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\SMTP.php';

// Database connection parameters
$host = '127.0.0.1'; // or your host
$dbUsername = 'root'; // or your db username
$dbPassword = ''; // or your db password
$dbName = 'firstdaydb'; // your database name

// Establishing connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $managementContactName = $conn->real_escape_string($_POST['managementContactName']);
    $managementContactPhone = $conn->real_escape_string($_POST['managementContactPhone']);
    $ownerEmail = $conn->real_escape_string($_POST['ownerEmail']);
    $password = $conn->real_escape_string($_POST['password']);

    // Hash the password - very important for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkUser = $conn->prepare("SELECT OwnerID FROM Owner_Profiles WHERE OwnerEmail = ?");
    $checkUser->bind_param("s", $ownerEmail);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists";
    } else {
        // Insert the new user into the database
        $insertStmt = $conn->prepare("INSERT INTO Owner_Profiles (ManagementContactName, ManagementContactPhone, OwnerEmail, Password, EmailVerified) VALUES (?, ?, ?, ?, FALSE)");
        $insertStmt->bind_param("ssss", $managementContactName, $managementContactPhone, $ownerEmail, $hashedPassword);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            echo "New record created successfully. Please verify your email.";

            // Generate a unique verification token
            $token = bin2hex(random_bytes(50)); // 50 bytes = 100 hex characters

            // Retrieve the ID of the newly inserted user
            $newUserId = $conn->insert_id;

            // Update the user record with this verification token
            $updateTokenSql = "UPDATE Owner_Profiles SET VerificationToken = ? WHERE OwnerID = ?";
            $tokenStmt = $conn->prepare($updateTokenSql);
            $tokenStmt->bind_param("si", $token, $newUserId);
            $tokenStmt->execute();
            $tokenStmt->close();

            // Prepare verification link
            $verificationLink = "http://127.0.0.1/firstday/verify-email.php?token=" . $token;

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jackbunckenburg@gmail.com'; // SMTP username
                $mail->Password = 'qzff rguu ahvk uaaf'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('noreply@yourwebsite.com', 'Mailer');
                $mail->addAddress($ownerEmail); // Add a recipient

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Email Verification';
                $mail->Body = "Please click on the following link to verify your email: <a href='" . $verificationLink . "'>" . $verificationLink . "</a>";
                $mail->AltBody = 'Please click on the following link to verify your email: ' . $verificationLink;

                $mail->send();
                echo 'Verification email sent.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $insertStmt->error;
        }
        $insertStmt->close();
    }

    $checkUser->close();
    $conn->close();
}
?>
