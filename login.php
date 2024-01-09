<?php
//login.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $host = '127.0.0.1'; // or your host
    $dbUsername = 'root'; // or your db username
    $dbPassword = ''; // or your db password
    $dbName = 'firstdaydb'; // your database name

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Password is not escaped because it will be hashed

    // Query to get the user's details from the database
    $stmt = $conn->prepare("SELECT OwnerID, password FROM owner_profiles WHERE ManagementContactName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password against the hashed password
        if (password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['logged_in'] = true; // Set a session variable to indicate the user is logged in
            $_SESSION['owner_id'] = $user['OwnerID']; // Store the OwnerID in the session
            $_SESSION['username'] = $username; // Store the username in the session
            header("Location: user-listings.php"); // Redirect to the user listings page
            exit;
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>
