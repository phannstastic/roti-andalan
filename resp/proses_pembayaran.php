<?php
session_start();
include('config.php');
include('config_midtrans.php'); // Menyertakan konfigurasi Midtrans
require_once('../vendor/autoload.php'); // Sertakan file autoload composer

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pesanan dan metode pembayaran yang dipilih
$id_user = $_SESSION['user'];
$id_pesanan = $_SESSION['last_order_id']; // Ambil ID pesanan terakhir yang sudah dibuat
$metode_pembayaran = $_POST['metode_pembayaran'];

// Ambil detail pesanan
$query = "SELECT * FROM pesanan WHERE id_pesanan = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $id_pesanan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$order) {
    die("Pesanan tidak ditemukan.");
}

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;
\Midtrans\Config::$clientKey = MIDTRANS_CLIENT_KEY;
\Midtrans\Config::$isProduction = false; // Atur ke true jika sudah di Production

// Data transaksi yang akan dikirim ke Midtrans
$transaction_details = array(
    'order_id' => $order['id_pesanan'],
    'gross_amount' => $order['total_harga'], // Total harga pesanan
);

// Pilihan metode pembayaran berdasarkan yang dipilih oleh pengguna
$payment_type = '';
$payment_channel = null;

if ($metode_pembayaran == 'virtual_account') {
    $payment_type = 'bank_transfer';
    $payment_channel = 'bca_va'; // Contoh untuk Bank BCA
} elseif ($metode_pembayaran == 'qris') {
    $payment_type = 'qris';
} elseif ($metode_pembayaran == 'bank_transfer') {
    $payment_type = 'bank_transfer';
}

$transaction_data = array(
    'payment_type' => $payment_type,
    'bank_transfer' => array(
        'bank' => $payment_channel,
    ),
);

// Gabungkan semua data
$transaction = array_merge($transaction_details, $transaction_data);

try {
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    // Redirect pengguna ke halaman Midtrans dengan token transaksi
    header("Location: https://app.sandbox.midtrans.com/snap/v1/vtweb/".$snapToken);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
