<?php
session_start();

if (isset($_POST['id_produk']) && isset($_SESSION['keranjang'])) {
    $id_produk = $_POST['id_produk'];
    
    if (isset($_SESSION['keranjang'][$id_produk])) {
        unset($_SESSION['keranjang'][$id_produk]);
        
        // Jika keranjang kosong, hapus session keranjang
        if (empty($_SESSION['keranjang'])) {
            unset($_SESSION['keranjang']);
        }
    }
}

header("Location: keranjang.php");
exit();
?>
