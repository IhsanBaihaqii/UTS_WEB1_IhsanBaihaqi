<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "db_penjualan_barang";
    $koneksi = mysqli_connect($host, $user, $password, $db);

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    // echo "Koneksi berhasil";
?>