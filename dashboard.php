<?php
    session_start();

    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #0056b3;
        }
        
        </style>
    </head>

    <body>
        <?php
            echo "<h2>Selamat datang, ". $_SESSION['username'] ."!</h2>";
        ?>
        <p>Role: <?php echo $_SESSION['role']; ?></p>
        <a href="logout.php">Logout</a>
    </body>
</html>