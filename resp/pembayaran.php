<?php
session_start();
include('config.php');
include('config_midtrans.php');

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Perbaikan: Gunakan key yang konsisten untuk total harga
$total_harga = isset($_SESSION['total_harga']) ? $_SESSION['total_harga'] : 0;

// Perbaikan: Cek apakah order ID ada di session
$last_order_id = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : 'Belum tersedia';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Pembayaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center mb-4">Pilih Metode Pembayaran</h3>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Pesanan Anda</h5>
                        <table class="table">
                            <tr>
                                <th>No. Pesanan</th>
                                <td><?php echo htmlspecialchars($last_order_id); ?></td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td>Rp. <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                            </tr>
                        </table>

                        <h5>Pilih Metode Pembayaran</h5>
                        <form action="proses_pembayaran.php" method="POST">
                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                                    <option value="virtual_account">Virtual Account</option>
                                    <option value="qris">QRIS</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Pilih Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>