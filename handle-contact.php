<?php
//handle-contact.php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Basic validation
    if (empty($name)) {
        die('Please enter your name.');
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Please enter a valid email address.');
    }
    if (empty($message)) {
        die('Please enter your message.');
    }

    // Prepare email content
    $to = 'jackbunckenburg@gmail.com, benbarr@windowslive.com'; // Both emails separated by a comma
    $subject = 'New Contact Form Submission';
    $emailContent = "Name: $name\n";
    $emailContent .= "Email: $email\n";
    $emailContent .= "Message: $message\n";

    $headers = "From: webmaster@example.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/".phpversion();

    // Send the email
    if(mail($to, $subject, $emailContent, $headers)) {
        echo "<h1>Thank You, $name!</h1>";
        echo "<p>We received your message and will get back to you soon.</p>";
    } else {
        echo "<h1>Oops!</h1>";
        echo "<p>Something went wrong, and we couldn't send your message.</p>";
    }
}
else {
    // Not a POST request, redirect to the contact form
    header('Location: contact.php');
    exit;
}
?>
