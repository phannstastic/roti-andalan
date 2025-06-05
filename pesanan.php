<?php
session_start();
include('config.php');
include('includes/header.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user'];

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold mb-0">Pesanan Saya</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pesanan Saya</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    $query = "SELECT * FROM pesanan WHERE id_pengguna = '$id_user' ORDER BY tanggal_pesanan DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn)); 
    }

    if (mysqli_num_rows($result) > 0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Riwayat Pesanan</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pesanan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tb   ody>
                        <?php
                        $no = 1;
                        while ($pesanan = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($pesanan['tanggal_pesanan'])); ?></td>
                                <td>Rp. <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Belum ada pesanan yang dilakukan.
        </div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
