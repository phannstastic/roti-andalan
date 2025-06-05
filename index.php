<?php 
session_start();
include('includes/header.php'); 
?>

<!-- Hero Section -->
<div class="hero-section text-center text-white d-flex align-items-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Selamat Datang di Toko Roti Kami!</h1>
        <p class="lead">Menyajikan Roti Segar Setiap Hari untuk Keluarga Tercinta</p>
        <a href="produk.php" class="btn btn-light btn-lg px-4">Lihat Menu Kami</a>
    </div>
</div>

<!-- Welcome Section -->
<section class="welcome-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Roti Berkualitas untuk Moment Spesial</h2>
                <p class="lead text-muted">Selamat datang di Toko Roti kami, tempat di mana setiap gigitan membawa kenangan manis untuk Anda dan keluarga.</p>
                <p>Kami memahami bahwa roti bukan sekadar makanan, tetapi bagian dari momen berharga dalam hidup Anda. Itulah mengapa kami selalu berkomitmen untuk:</p>
                <ul class="feature-list">
                    <li><i class="bi bi-check-circle-fill text-success"></i> Menggunakan bahan berkualitas premium</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Dipanggang segar setiap hari</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Resep tradisional yang sempurna</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="assets/images/eat.webp" alt="eat" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Profile Section -->
<section class="profile-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <img src="assets/images/p.jpg" alt="Profile" class="img-fluid rounded-circle shadow">
            </div>
            <div class="col-lg-7">
                <h2 class="section-title">Tentang Kami</h2>
                <p class="lead">Perjalanan Kami Dalam Membuat Roti Terbaik</p>
                <p>Toko Roti kami didirikan dengan passion untuk menciptakan roti dan kue berkualitas yang bisa dinikmati oleh semua kalangan. Dengan pengalaman lebih dari 10 tahun dalam industri bakery, kami terus berinovasi untuk menghadirkan produk-produk terbaik.</p>
                <div class="achievements mt-4">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="achievement-item">
                                <h3>10+</h3>
                                <p>Tahun Pengalaman</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="achievement-item">
                                <h3>5+</h3>
                                <p>Varian Roti</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="achievement-item">
                                <h3>1000+</h3>
                                <p>Pelanggan Puas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/home.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin-top: -56px;
    }

    .section-title {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .feature-list {
        list-style: none;
        padding-left: 0;
        margin-top: 2rem;
    }

    .feature-list li {
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .feature-list i {
        margin-right: 10px;
    }

    .achievement-item {
        padding: 1.5rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .achievement-item:hover {
        transform: translateY(-5px);
    }

    .achievement-item h3 {
        color: #e67e22;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .achievement-item p {
        color: #7f8c8d;
        margin-bottom: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-section {
            height: 70vh;
        }
        
        .achievement-item {
            margin-bottom: 1rem;
        }
    }
</style>

<?php include('includes/footer.php'); ?>