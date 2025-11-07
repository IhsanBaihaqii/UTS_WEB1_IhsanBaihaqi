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

    $jumlah = count($nama_barang) - 1;
    $beli = 0;
    $total = 0;
    $grandtotal = 0
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

         main{
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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

        <main>
            <h2>Daftar Barang</h2>
            <p>Daftar pembelian dibuat secara acak tiap kali halaman dimuat</p>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang (Rp)</th>
                    <th>Jumlah</th>
                    <th>Total (Rp)</th>
                </tr>
                <?php
                    for ($i=0; $i < rand(1, $jumlah); $i++) {
                        $beli = rand(1, 10);
                        $id_barang = rand(0, $jumlah);
                        $total = $harga_barang[$i] * $beli;
                        $grandtotal += $total;

                        echo "<tr>";
                        echo "<td>" . $kode_barang[$id_barang] . "</td>";
                        echo "<td>" . $nama_barang[$id_barang] . "</td>";
                        echo "<td style='text-align:right;'>" . number_format($harga_barang[$id_barang], 0, ',', '.') . "</td>";
                        echo "<td style='text-align:center;'>" . $beli . "</td>";
                        echo "<td style='text-align:right;'>" . number_format($total, 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                ?>
                <tr>
                    <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Belanja</strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($grandtotal, 0, ',', '.'); ?></strong></td>
                </tr>
                </table>
        </main>


    </body>
</html>