<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

// Mendapatkan total pesanan dari session
$total_pesanan = isset($_SESSION['total_pesanan']) ? $_SESSION['total_pesanan'] : 0;
?>

<?php include('includes/header.php'); ?>

<!-- Profile Section -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="profile-image-wrapper mb-4">
                        <img src="assets/images/duck.jpg" alt="Profile" class="rounded-circle profile-image">
                    </div>
                    <h3 class="mb-0"><?php echo $username; ?></h3>
                    <p class="text-muted mb-4">Alomani</p>
                    <div class="d-grid gap-2">
                        <a href="keranjang.php" class="btn btn-primary">
                            <i class="bi bi-cart"></i> Lihat Keranjang
                        </a>
                        <a href="logout.php" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4">Informasi Akun</h4>
                    
                    <!-- Account Stats -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="stats-card bg-primary bg-opacity-10 rounded p-3 text-center">
                                <i class="bi bi-cart-check fs-3 text-primary mb-2"></i>
                                <h5>Class</h5>
                                <p class="h3 mb-0">Basic</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card bg-success bg-opacity-10 rounded p-3 text-center">
                                <i class="bi bi-star fs-3 text-success mb-2"></i>
                                <h5>Pencinta Roti Sejak</h5>
                                <p class="h3 mb-0">2024</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card bg-info bg-opacity-10 rounded p-3 text-center">
                                <i class="bi bi-clock-history fs-3 text-info mb-2"></i>
                                <h5>Member Sejak</h5>
                                <p class="h3 mb-0">2024</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <h5 class="mb-3">Aktivitas Terbaru</h5>
                        <div class="activity-item border-start border-2 border-primary ps-3 mb-3">
                            <p class="mb-0">Hai, Selamat Bergabung!</p>
                            <small class="text-muted">Hari ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-image-wrapper {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    position: relative;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.stats-card {
    transition: transform 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.activity-item {
    position: relative;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: -5px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #0d6efd;
}
</style>

<?php include('includes/footer.php'); ?>
