<?php
    session_start();

    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    $kode_barang = [
        'K001', 'K002', 'K003', 'K004', 'K005'
    ];

     $nama_barang = [
        'Teh Pucuk',
        'Sukro',
        'Sprite',
        'Coca Cola',
        'Chitose'
    ];

    $harga_barang = [
        3000, 2500, 5000, 6000, 4000
    ];

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
        header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .cotainer1 {
            color: white;
            text-align: center;
        }
        .container2 {
            border-radius: 5px;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 5px;
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
        <header>
            <div class="container1">
                <h1>--Polgan Mart--</h1>
                <p>Sistem penjualan sederhana</p>
            </div>
            <div class="container2">
                <?php
                    echo "<h2>Selamat datang, ". $_SESSION['username'] ."!</h2>";
                ?>
                <p>Role: <?php echo $_SESSION['role']; ?></p>
                <a href="logout.php">Logout</a>
            </div>
        </header>
    </body>
</html>