<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user'];

$user_query = "SELECT username, email FROM pengguna WHERE username = ?";
$stmt = mysqli_prepare($conn, $user_query);
if ($stmt === false) {
    die("Error preparing user query: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $id_user);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);

if (!$user_result) {
    die("Error executing user query: " . mysqli_error($conn));
}

$user_data = mysqli_fetch_assoc($user_result);
mysqli_stmt_close($stmt);

$query = "SELECT p.*, pd.id_produk, pd.quantity, pr.nama as nama_produk, pr.harga 
          FROM pesanan p 
          LEFT JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan 
          LEFT JOIN produk pr ON pd.id_produk = pr.id_produk 
          WHERE p.id_pengguna = ? 
          ORDER BY p.tanggal_pesanan DESC";

$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Error preparing order query: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error executing order query: " . mysqli_error($conn));
}

$orders = array();
while ($row = mysqli_fetch_assoc($result)) {
    $id_pesanan = $row['id_pesanan'];
    if (!isset($orders[$id_pesanan])) {
        $orders[$id_pesanan] = array(
            'id_pesanan' => $row['id_pesanan'],
            'tanggal_pesanan' => $row['tanggal_pesanan'],
            'total_harga' => $row['total_harga'],
            'items' => array()
        );
    }
    if ($row['id_produk']) {
        $orders[$id_pesanan]['items'][] = array(
            'nama_produk' => $row['nama_produk'],
            'quantity' => $row['quantity'],
            'harga' => $row['harga']
        );
    }
}
mysqli_stmt_close($stmt);

$latest_order = reset($orders);

if (empty($orders)) {
    echo "Debug Info:<br>";
    echo "User ID: " . htmlspecialchars($id_user) . "<br>";
    echo "User Data: ";
    print_r($user_data);
    echo "<br>";
    echo "Last SQL Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-message {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .success-icon {
            color: #28a745;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .table-items {
            font-size: 0.9rem;
        }
        .table-items th {
            background-color: #f8f9fa;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .success-message {
                box-shadow: none;
                border: none;
            }
        }
        .print-only {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (!empty($user_data) && !empty($latest_order)): ?>
                <div class="success-message">
                    <!-- Print Header -->
                    <div class="print-only text-center mb-4">
                        <h3>BUKTI PEMBELIAN</h3>
                        <p>Roti Rotian<br>
                        Gang Menco, RT.3/RW.0, Desa Kragilan, Banguntapan<br>
                        Telp: (+62)822 8888 4953</p>
                        <hr>
                    </div>

                    <!-- Success Message -->
                    <div class="text-center">
                        <div class="success-icon no-print">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="mb-4 no-print">Pesanan Anda Berhasil!</h2>
                    </div>

                    <!-- Customer Details -->
                    <div class="mb-4">
                        <h5 class="mb-3">Informasi Pelanggan:</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>: <?php echo htmlspecialchars($user_data['username']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: <?php echo htmlspecialchars($user_data['email']); ?></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Order Details -->
                    <div class="mb-4">
                        <h5 class="mb-3">Detail Pesanan:</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>No. Pesanan</strong></td>
                                <td>: <?php echo $latest_order['id_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td>: <?php echo date('d/m/Y H:i', strtotime($latest_order['tanggal_pesanan'])); ?></td>
                            </tr>
                        </table>

                        <!-- Order Items -->
                        <h5 class="mb-3">Item Pesanan:</h5>
                        <table class="table table-items">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latest_order['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-right">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td class="text-right">Rp <?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php 
                                $subtotal = array_sum(array_map(function($item) {
                                    return $item['harga'] * $item['quantity'];
                                }, $latest_order['items']));
                                
                                if ($subtotal >= 30000): 
                                ?>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                                    <td class="text-right">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right text-success"><strong>Diskon 50%</strong></td>
                                    <td class="text-right text-success">- Rp <?php echo number_format($subtotal * 0.5, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total Bayar</strong></td>
                                    <td class="text-right"><strong>Rp <?php echo number_format($latest_order['total_harga'], 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mb-4">
                        <p>Terima kasih telah berbelanja di Toko Roti</p>
                        <p class="no-print">Silakan tunggu konfirmasi lebih lanjut mengenai pengiriman pesanan Anda.</p>
                    </div>

                    <div class="print-only text-center mt-4">
                        <hr>
                        <p>Barang yang sudah dibeli tidak dapat dikembalikan.<br>
                        Terima kasih atas kepercayaan Anda!</p>
                    </div>

                    <div class="text-center mt-4 no-print">
                        <button onclick="window.print()" class="btn btn-success btn-lg mr-2">
                            <i class="fas fa-print"></i> Cetak Struk
                        </button>
                        <a href="index.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    <h4>Tidak ada data pesanan</h4>
                    <p>Silakan periksa apakah Anda sudah melakukan checkout dengan benar.</p>
                    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>