<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        .hidden {
            display: none;
        }
        .button-container {
            text-align: center;
            margin: 0 auto;
            margin-top: 20px;
        }
        #loginForm, #registrationForm {
            text-align: center;
            margin: 0 auto;
        }
        /* Additional styles can go here */
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="button-container">
        <button id="signInBtn">Sign In</button>
        <button id="signUpBtn">Sign Up</button>
    </div>

    <div id="loginForm" class="hidden">
        <form action="login-owners.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </div>

    <div id="registrationForm" class="hidden">
        <form action="register.php" method="post">
            <label for="reg_managementContactName">Name:</label><br>
            <input type="text" id="reg_managementContactName" name="managementContactName" required><br>

            <label for="reg_managementContactPhone">Phone:</label><br>
            <input type="text" id="reg_managementContactPhone" name="managementContactPhone" required><br>

            <label for="reg_ownerEmail">Email:</label><br>
            <input type="email" id="reg_ownerEmail" name="ownerEmail" required><br>

            <label for="reg_password">Password:</label><br>
            <input type="password" id="reg_password" name="password" required><br><br>

            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        document.getElementById('signInBtn').addEventListener('click', function() {
            document.getElementById('loginForm').classList.toggle('hidden');
            if (!document.getElementById('registrationForm').classList.contains('hidden')) {
                document.getElementById('registrationForm').classList.add('hidden');
            }
        });

        document.getElementById('signUpBtn').addEventListener('click', function() {
            document.getElementById('registrationForm').classList.toggle('hidden');
            if (!document.getElementById('loginForm').classList.contains('hidden')) {
                document.getElementById('loginForm').classList.add('hidden');
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
