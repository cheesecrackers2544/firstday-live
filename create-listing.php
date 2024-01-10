<?php
//Used for registered users to create a new listing. Upon doing so, sends an email to the admin for approval.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\Exception.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\PHPMailer.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials should be stored in a separate configuration file
    $host = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'firstdaydb';

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO listings (Title, Description, Price, Telephone, Email, StreetAddress, Suburb, TownCity, ServiceType, HoursECE, AreaUnit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssssss", $title, $description, $price, $telephone, $email, $streetAddress, $suburb, $townCity, $serviceType, $hoursECE, $areaUnit);

    // Sanitize and validate input data here
    $title = $_POST['title'];
    // ... other variables

    if ($stmt->execute()) {
        // Retrieve the last inserted ID
        $lastInsertedId = $conn->insert_id;

        // Set $listingId to the last inserted ID
        $listingId = $lastInsertedId;

        echo "New record created successfully";

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

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'Mailer');
            $mail->addAddress('jackbunckenburg@gmail.com', 'Recipient Name');

            // Email Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'New Listing Authorization Request';
            $body = "A new listing has been created and requires authorization.<br><br>";
            $body .= "Listing Details:<br>";
            $body .= "Title: " . $title . "<br>";
            $body .= "Description: " . $description . "<br>";
            // ... add other details as needed
            $body .= "<a href='http://localhost/firstday-live/accept.php?id=$listingId'>Accept</a><br>";
            $body .= "<a href='http://localhost/firstday-live/decline.php?id=$listingId'>Decline</a>";
    
            $mail->Body = $body;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Listing</title>
</head>
<body>
    <h2>Create a Listing</h2>
    <form method="post" action="create-listing.php">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br>

        <label for="telephone">Telephone:</label><br>
        <input type="text" id="telephone" name="telephone" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="streetAddress">Street Address:</label><br>
        <input type="text" id="streetAddress" name="streetAddress" required><br>

        <label for="suburb">Suburb:</label><br>
        <input type="text" id="suburb" name="suburb" required><br>

        <label for="townCity">Town/City:</label><br>
        <input type="text" id="townCity" name="townCity" required><br>

        <label for="serviceType">Service Type:</label><br>
        <input type="text" id="serviceType" name="serviceType" required><br>

        <label for="hoursECE">Hours ECE:</label><br>
        <input type="text" id="hoursECE" name="hoursECE" required><br>

        <label for="areaUnit">Area Unit:</label><br>
        <input type="text" id="areaUnit" name="areaUnit" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
