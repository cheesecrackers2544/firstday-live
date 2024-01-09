<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php include 'header.php'; ?>
    <main>
        <div id="search-container">
            <!-- The action attribute should point to the PHP file handling the search -->
            <form action="search.php" method="get">
                <input type="text" name="query" id="search-box" placeholder="Enter a town, city or suburb">
                <input type="submit" value="Search">
            </form>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>


