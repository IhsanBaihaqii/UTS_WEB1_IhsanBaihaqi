<?php
    session_start();

    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    //Simpan Array barang ke session
    if (!isset($_SESSION['barang'])) {
        $_SESSION['barang'] = [];
    }

    // Cek apakah ada pengiriman data (post)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $kode_barang   = $_POST['kode_barang'] ?? '';
        $nama_barang   = $_POST['nama_barang'] ?? '';
        $harga_barang  = (int)($_POST['harga_barang'] ?? 0);
        $jumlah = (int)($_POST['jumlah']  ?? 0);

        $_SESSION['barang'][] = [
            'kode_barang'  => $kode_barang,
            'nama_barang'  => $nama_barang,
            'harga_barang' => $harga_barang,
            'jumlah'       => $jumlah
        ];

    }
    $barang = $_SESSION['barang']; 
    // Reset keranjang jika ada request GET
    if (isset($_GET["reset"])) {
        unset($_SESSION['barang']);
        $barang = null;
        header("Location: dashboard.php");
        exit;
    }

    $list_barang = [
        ["kode_barang" => "B001", "nama_barang" => "Pensil", "harga_barang" => 2000],
        ["kode_barang" => "B002", "nama_barang" => "Buku Tulis", "harga_barang" => 5000],
        ["kode_barang" => "B003", "nama_barang" => "Penghapus", "harga_barang" => 1500],
        ["kode_barang" => "B004", "nama_barang" => "Penggaris", "harga_barang" => 3000],
    ];

    $grandtotal = 0;
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

        form {
            width: 90%;
            margin-bottom: 30px;
            padding: 20px;
        }
        #list_barang {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container {
            display: flex;
        }
        input[type="submit"], input[type="reset"] {
            width: 40%;
            padding: 10px;
            margin: 10px 1%;
            border: none;
            border-radius: 4px;
            background-color: #0056b3;
            color: white;
            cursor: pointer;
        }
        input[type="reset"] {
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
        }


       table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
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
            <!-- input Kode Barang, nama barang, harga, jumlah -->
            <form action="dashboard.php" method="post">

                <label for="list_barang">Kode Barang</label>
                <select name="list_barang" id="list_barang">
                    <option value="">-- Pilih Kode Barang --</option>
                    <?php foreach ($list_barang as $item): ?>
                        <option value="<?php echo $item['kode_barang'] . '|' . $item['nama_barang'] . '|' . $item['harga_barang']; ?>">
                            <?php echo $item['kode_barang'] . " | " . $item['nama_barang'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="kode_barang">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang" placeholder="Masukkan Kode Barang" required><br>
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" placeholder="Masukkan Kode Barang" required><br>
                <label for="harga_barang">Harga</label>
                <input type="number" name="harga_barang" id="harga_barang" placeholder="Masukkan Harga Barang" required><br>
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah" required><br>
                <div class="container">
                    <input type="submit" value="Tambahkan">
                    <input type="reset" value="Batal">
                </div>

            </form>
            <?php if (isset($_SESSION["barang"]) && !empty($barang)): ?>
                <h2>Daftar Barang</h2>
                <p>Menampilkan barang yang di input</p>
                <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang (Rp)</th>
                    <th>Jumlah</th>
                    <th>Total (Rp)</th>
                </tr>
                <?php
                foreach ($barang as $item) {
                    $kode_barang = $item['kode_barang'];
                    $nama_barang = $item['nama_barang'];
                    $harga_barang = $item['harga_barang'];
                    $jumlah = $item['jumlah'];

                    // hitung total
                    $total_harga = $harga_barang * $jumlah;
                    $grandtotal += $total_harga;

                    // hitung diskon
                    if ($grandtotal == 0) {
                        $d = "0%";
                        $diskon = 0;
                    } elseif ($grandtotal < 50000) {
                        $d = "5%";
                        $diskon = 0.05 * $grandtotal;
                    } elseif ($grandtotal <= 100000) {
                        $d = "10%";
                        $diskon = 0.10 * $grandtotal;
                    } else {
                        $d = "15%";
                        $diskon = 0.15 * $grandtotal;
                    }
                    $totalbayar = $grandtotal - $diskon;

                    echo "<tr>";
                    echo "<td>" . $kode_barang . "</td>";
                    echo "<td>" . $nama_barang . "</td>";
                    echo "<td style='text-align:right;'>" . number_format($harga_barang,  0, ',', '.') . "</td>";
                    echo "<td style='text-align:center;'>" . $jumlah . "</td>";
                    echo "<td style='text-align:right;'>" . number_format($total_harga,  0, ',', '.'). "</td>";
                    echo "</tr>";
                }
                ?>
                <!-- Total Belanja, Diskon, Total Bayar -->
                <tr>
                    <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Belanja</strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($grandtotal,  0, ',', '.'); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right; padding-right:20px"><strong><?php echo "Diskon ". $d; ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($diskon,  0, ',', '.'); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Bayar</strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($totalbayar, 0, ',', '.'); ?></strong></td>
                </tr>
                </table>
                <!-- Reset Keranjang -->
                <form action="dashboard.php" method="get" style="margin-top:20px;">
                    <input type="submit" value="Reset Keranjang" name="reset">
                </form>
            <?php endif; ?>
        </main>
    </body>
    <script>
            // Mengisi input kode_barang, nama_barang, harga_barang berdasarkan pilihan list
    document.getElementById('list_barang').addEventListener('change', function() {
        var selectedOption = this.value.split('|');
        document.getElementById('kode_barang').value = selectedOption[0];
        document.getElementById('nama_barang').value = selectedOption[1];
        document.getElementById('harga_barang').value = selectedOption[2];
    });
    </script>
</html>