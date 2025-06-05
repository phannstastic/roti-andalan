<?php
session_start();
include('config.php');

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
        }
        .navbar {
            padding: 1rem 0;
            background-color: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: #4b5563 !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link.active {
            color: var(--primary-color) !important;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu {
            border: none;
            display: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #ffffff;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                margin-top: 1rem;
            }
        }
        .nav-item.dropdown::marker{
            display: none;
        }
</style>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar Admin (Disesuaikan dengan index.php) -->
        <nav class="bg-white p-4 text-blue-600">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Logo Admin Panel -->
                <a href="#" class="flex items-center space-x-2 font-bold text-2xl">
                    <i class="bi bi-shop me-2"></i>
                        Roti Rotian
                </a>
                <div class="flex space-x-4">
                    <!-- Tombol Logout disesuaikan -->
                        <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i><?php echo $_SESSION['user']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="akun.php">
                                    <i class="bi bi-person me-2"></i>Profil Saya
                                </a></li>
                                <li><a class="dropdown-item" href="pesanan.php">
                                    <i class="bi bi-bag me-2"></i>Pesanan Saya
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-primary me-2" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="register.php">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto flex-1 p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Product Management Section -->
                <div class="bg-white p-6 shadow-lg rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Kelola Produk</h3>
                    <a href="tambah_produk.php" class="block bg-blue-500 text-white p-3 rounded-lg text-center mb-4 hover:bg-blue-600 transition-all duration-300">Tambah Produk</a>
                    <a href="edit_produk.php" class="block bg-yellow-500 text-white p-3 rounded-lg text-center hover:bg-yellow-600 transition-all duration-300">Edit Produk</a>
                </div>
                
                <!-- Payment Verification Section -->
                <div class="bg-white p-6 shadow-lg rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Verifikasi Pembayaran</h3>
                    <a href="verifikasi_pembayaran.php" class="block bg-green-500 text-white p-3 rounded-lg text-center hover:bg-green-600 transition-all duration-300">Verifikasi Pembayaran</a>
                </div>

                <!-- Order Management Section -->
                <div class="bg-white p-6 shadow-lg rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Daftar Pesanan</h3>
                    <a href="pesanan.php" class="block bg-indigo-500 text-white p-3 rounded-lg text-center hover:bg-indigo-600 transition-all duration-300">Lihat Daftar Pesanan</a>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 5rem;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
