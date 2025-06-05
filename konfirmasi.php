<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['total_pesanan']) || $_SESSION['total_pesanan'] == 0) {
    header("Location: keranjang.php");
    exit();
}

$total_pesanan = $_SESSION['total_pesanan'];
$id_user = $_SESSION['user']; 

$query = "INSERT INTO pesanan (id_pengguna, total_harga) VALUES ('$id_user', '$total_pesanan')";
if (mysqli_query($conn, $query)) {
    unset($_SESSION['total_pesanan']);

    header("Location: pesanan_sukses.php");
} else {

    die("Query gagal: " . mysqli_error($conn));
}
?>
