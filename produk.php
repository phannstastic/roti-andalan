<?php 
session_start();
include('config.php');
include('includes/header.php'); 

if (isset($_GET['add'])) {
    $id_produk = $_GET['add'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] += $quantity;
    } else {
        $_SESSION['keranjang'][$id_produk] = $quantity;
    }

    header("Location: keranjang.php");
    exit();
}

$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<div class="product-hero text-center text-white py-5">
    <div class="container">
        <h1 class="display-4">Menu Roti Kami</h1>
        <p class="lead">Dipanggang Segar Setiap Hari dengan Bahan Berkualitas Premium</p>
    </div>
</div>

<div class="container my-4">
    <form action="produk.php" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="<?php echo htmlspecialchars($keyword); ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>

<div class="container my-5">
    <div class="row g-4">
        <?php

        $query = "SELECT * FROM produk";
        if ($keyword) {
            $query .= " WHERE nama LIKE '%$keyword%' OR harga LIKE '%$keyword%'";
        }

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
                    <div class="product-card shadow-sm">
                        <div class="product-image-wrapper">
                            <img src="assets/images/'.$row['gambar'].'" alt="'.$row['nama'].'">
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h5>'.$row['nama'].'</h5>
                                    <p>Rp. '.number_format($row['harga'], 0, ',', '.').'</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">'.$row['nama'].'</h5>
                            <p class="card-text">Rp. '.number_format($row['harga'], 0, ',', '.').'</p>
                            <form action="produk.php?add='.$row['id_produk'].'" method="POST">
                                <div class="quantity-input">
                                    <button type="button" onclick="decrementQuantity(this)">-</button>
                                    <input type="number" name="quantity" value="1" min="1" max="99">
                                    <button type="button" onclick="incrementQuantity(this)">+</button>
                                </div>';
                if (isset($_SESSION['user'])) {
                    echo '<button type="submit" class="btn btn-primary w-100">Tambah ke Keranjang</button>';
                } else {
                    echo '<a href="login.php" class="btn btn-warning w-100">Login untuk membeli</a>';
                }
                echo '</form>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p class="text-center">Tidak ada produk ditemukan.</p>';
        }
        ?>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="spinner"></div>
</div>

<!-- JavaScript untuk Tombol - dan + -->
<script>
    // Fungsi untuk mengurangi jumlah kuantitas
    function decrementQuantity(button) {
        var input = button.parentElement.querySelector('input[type="number"]');
        var currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    // Fungsi untuk menambah jumlah kuantitas
    function incrementQuantity(button) {
        var input = button.parentElement.querySelector('input[type="number"]');
        var currentValue = parseInt(input.value);
        input.value = currentValue + 1;
    }
</script>

<!-- CSS -->
<style>
/* Hero Section */
.product-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/images/produk.jpg');
    background-size: cover;
    background-position: center;
    padding: 100px 0;
    margin-bottom: 30px;
}

/* Product Cards */
.product-card {
    transition: transform 0.3s ease;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Image Container */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    padding-top: 75%; /* Creates a 4:3 aspect ratio */
    width: 100%;
}

.product-image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

/* Card Body */
.card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    height: 2.4rem; /* Fixed height for title - approximately 2 lines */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.card-text {
    font-size: 1rem;
    color: #666;
    margin-bottom: 1rem;
}

/* Quantity Input Container */
.quantity-input {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    height: 38px; /* Fixed height for quantity input */
}

.quantity-input input {
    width: 60px;
    height: 38px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 0;
}

.quantity-input button {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    background: #f8f8f8;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Add to Cart Button */
.btn {
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Grid Layout */
.row {
    display: flex;
    flex-wrap: wrap;
    margin: -12px; 
}

.col-sm-12,
.col-md-6,
.col-lg-4 {
    padding: 12px; 
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .product-image-wrapper {
        padding-top: 66.67%; 
    }
    
    .card-title {
        font-size: 1rem;
        height: 2.2rem;
    }
    
    .card-text {
        font-size: 0.9rem;
    }
}
</style>

<?php include('includes/footer.php'); ?>
