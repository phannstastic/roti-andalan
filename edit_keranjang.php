<?php
session_start();

if (isset($_POST['id_produk']) && isset($_POST['quantity']) && isset($_SESSION['keranjang'])) {
    $id_produk = $_POST['id_produk'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) {
        $_SESSION['keranjang'][$id_produk] = $quantity;
    }
}

header("Location: keranjang.php");
exit();
?>
