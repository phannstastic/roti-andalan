<?php
session_start();
include('config.php');
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data produk dari form
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    
    // Upload gambar
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'assets/images/' . $gambar);
    
    // Insert data ke database
    $query = "INSERT INTO produk (nama, harga, deskripsi, gambar) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $nama_produk, $harga, $deskripsi, $gambar);
    mysqli_stmt_execute($stmt);

    // Redirect ke halaman produk
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-5">
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Tambah Produk Baru</h2>
            <form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama_produk" class="block text-sm font-semibold">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="w-full p-3 mt-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="harga" class="block text-sm font-semibold">Harga</label>
                    <input type="number" name="harga" id="harga" class="w-full p-3 mt-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full p-3 mt-2 border rounded" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-semibold">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" class="w-full p-3 mt-2 border rounded" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white p-3 rounded mt-4 w-full">Tambah Produk</button>
            </form>
        </div>
    </div>

</body>
</html>
