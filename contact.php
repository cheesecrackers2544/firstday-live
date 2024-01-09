<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<main>
    <h1>Contact Us</h1>
    <p>If you have any questions, please fill out the form below and we'll get back to you as soon as possible.</p>

    <form action="handle-contact.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
</main>

<?php include 'footer.php'; ?>

</body>
</html>


