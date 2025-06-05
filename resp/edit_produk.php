<?php
session_start();
include('config.php');
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data produk dari form
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    
    // Cek jika ada gambar yang diupload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'assets/images/' . $gambar);
        $query = "UPDATE produk SET nama = ?, harga = ?, deskripsi = ?, gambar = ? WHERE id_produk = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $nama_produk, $harga, $deskripsi, $gambar, $id_produk);
    } else {
        $query = "UPDATE produk SET nama = ?, harga = ?, deskripsi = ? WHERE id_produk = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssi', $nama_produk, $harga, $deskripsi, $id_produk);
    }
    mysqli_stmt_execute($stmt);
    header("Location: admin.php");
    exit();
}

$id_produk = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_produk);
mysqli_stmt_execute($stmt);
$product = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-5">
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Edit Produk</h2>
            <form action="edit_produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?php echo $product['id_produk']; ?>">
                <div class="mb-4">
                    <label for="nama_produk" class="block text-sm font-semibold">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="w-full p-3 mt-2 border rounded" value="<?php echo $product['nama']; ?>" required>
                </div>

                <div class="mb-4">
                    <label for="harga" class="block text-sm font-semibold">Harga</label>
                    <input type="number" name="harga" id="harga" class="w-full p-3 mt-2 border rounded" value="<?php echo $product['harga']; ?>" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full p-3 mt-2 border rounded" required><?php echo $product['deskripsi']; ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-semibold">Gambar Produk (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="gambar" id="gambar" class="w-full p-3 mt-2 border rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white p-3 rounded mt-4 w-full">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</body>
</html>
