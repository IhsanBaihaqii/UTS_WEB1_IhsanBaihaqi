<?php
    session_start();

    include 'koneksi.php';

    $results = mysqli_query($koneksi, "SELECT * FROM tbl_barang");
    $data_barang = mysqli_fetch_all($results, MYSQLI_ASSOC);

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

        if (isset($_POST["tambah_barang"])) {
            // Proses penambahan barang ke keranjang
            $kode_barang   = $data_barang[ $_POST['list_barang'] ]['kode_barang'] ?? '';
            $nama_barang   = $_POST['nama_barang'] ?? '';
            $harga_barang  = (int)($_POST['harga_barang'] ?? 0);
            $jumlah = (int)($_POST['jumlah']  ?? 0);

            $_SESSION['barang'][$kode_barang] = [
                'kode_barang'  => $kode_barang,
                'nama_barang'  => $nama_barang,
                'harga_barang' => $harga_barang,
                'jumlah'       => $jumlah
            ];

        }
    }
// Fungsi Menghapus
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET["hapus"])) {
            unset($_SESSION['barang'][$_GET["hapus"]]);
            header("Location: dashboard.php");
        }
    }

    $barang = $_SESSION['barang'];

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
        button {
            width: 40%;
            padding: 10px;
            margin: 10px 1%;
            border: none;
            border-radius: 4px;
            background-color: #0056b3;
            color: white;
            cursor: pointer;
        }
        button[type="reset"] {
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
        }
        button[name="hapus"] {
            background-color: red;
            color: white;
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
                    <option disabled selected>-- Pilih Kode Barang --</option>
                    <?php foreach ($data_barang as $index => $item) : ?>
                        <option value="<?php echo $index; ?>">
                            <?php echo $item["kode_barang"] . " | " . $item['nama_barang'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" placeholder="Masukkan Kode Barang" required><br>
                <label for="harga_barang">Harga</label>
                <input type="number" name="harga_barang" id="harga_barang" placeholder="Masukkan Harga Barang" required><br>
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah" required><br>
                <div class="container">
                    <button type="submit" value="Tambahkan" name="tambah_barang">Tambahkan</button>
                    <button type="reset" value="Batal">Batal</button>
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
                    <th>Action</th>
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
                    echo "<td style='text-align:center;'> <form method='GET'><button type='submit' name='hapus' value=$kode_barang>Hapus</button></form> </td>";
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
                    <button type="submit" name="reset">Reset Keranjang</button>
                </form>
            <?php endif; ?>
        </main>
    </body>
   
    <script>
        //munculkan nama baranng, harga barang
        const kodeSelect = document.getElementById('list_barang');
        const namaInput = document.getElementById('nama_barang');
        const hargaInput = document.getElementById('harga_barang');

        const barangData = <?php echo json_encode($data_barang); ?>;
        kodeSelect.addEventListener('change', function() {
            const selectedKode = this.value;
            if (barangData[selectedKode]) {
                namaInput.value = barangData[selectedKode].nama_barang;
                hargaInput.value = barangData[selectedKode].harga;
            } else {
                namaInput.value = '';
                hargaInput.value = '';
            }
        });
    </script>

</html>