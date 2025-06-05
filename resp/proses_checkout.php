<?php
session_start();
include('config.php');

if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
    if (isset($_SESSION['user'])) {
        $id_pengguna = $_SESSION['user'];
        $total_harga = 0;
        
        // Hitung total harga
        foreach ($_SESSION['keranjang'] as $id_produk => $quantity) {
            $query = "SELECT harga FROM produk WHERE id_produk = $id_produk";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
            $total_harga += $product['harga'] * $quantity;
        }

        // Insert ke tabel pesanan
        $query_pesanan = "INSERT INTO pesanan (id_pengguna, tanggal_pesanan, total_harga) 
                         VALUES (?, NOW(), ?)";
        $stmt = mysqli_prepare($conn, $query_pesanan);
        mysqli_stmt_bind_param($stmt, "sd", $id_pengguna, $total_harga);
        mysqli_stmt_execute($stmt);
        
        // Dapatkan id_pesanan yang baru saja dibuat
        $id_pesanan = mysqli_insert_id($conn);
        
        // Insert setiap item ke pesanan_detail
        foreach ($_SESSION['keranjang'] as $id_produk => $quantity) {
            $query = "SELECT harga FROM produk WHERE id_produk = $id_produk";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
            $harga_produk = $product['harga'];
            $subtotal = $harga_produk * $quantity;
            
            $query_detail = "INSERT INTO pesanan_detail (id_pesanan, id_produk, quantity, total_harga) 
                            VALUES (?, ?, ?, ?)";
            $stmt_detail = mysqli_prepare($conn, $query_detail);
            mysqli_stmt_bind_param($stmt_detail, "iiid", $id_pesanan, $id_produk, $quantity, $subtotal);
            mysqli_stmt_execute($stmt_detail);
        }

        // mengosongkan keranjang
        unset($_SESSION['keranjang']);
        
        $_SESSION['checkout_success'] = true;
        $_SESSION['last_order_id'] = $id_pesanan;

        header("Location: pesanan_sukses.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: keranjang.php");
    exit();
}
?>