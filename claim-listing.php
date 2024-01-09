<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\Exception.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\PHPMailer.php';
require 'C:\Users\David\Documents\Firstday\PHPMailer-master\src\SMTP.php';

if (isset($_POST['submit'])) {
    $listingId = $_POST['listingId'];
    $claimerEmail = $_POST['email'];
    $claimerMessage = $_POST['message'];

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
        $mail->setFrom('your-email@gmail.com', 'Mailer');
        $mail->addAddress('jackbunckenburg@gmail.com', 'Jack Bunckenburg'); // Add a recipient

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Listing Claim Request';
        $mail->Body    = "Listing ID: $listingId\nClaimer Email: $claimerEmail\nMessage: $claimerMessage";

        $mail->send();
        echo 'Claim request sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Display the form
    $listingId = $_GET['id'];
    ?>
    <form action="claim-listing.php" method="post">
        <input type="hidden" name="listingId" value="<?php echo $listingId; ?>">
        <p>Email: <input type="email" name="email" required></p>
        <p>Message: <textarea name="message" required></textarea></p>
        <p><input type="submit" name="submit" value="Submit Claim"></p>
    </form>
    <?php
}
?>
