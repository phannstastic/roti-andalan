<?php
session_start(); 
include('includes/header.php'); 
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (!isset($_SESSION['user'])): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-lock-fill text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="mb-3">Ups, Anda belum login!</h4>
                <p class="text-muted mb-4">Anda harus login terlebih dahulu untuk dapat memasukkan barang ke keranjang.</p>
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <a href="login.php" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
                    </a>
                    <a href="register.php" class="btn btn-outline-secondary">
                        <i class="bi bi-person-plus me-2"></i>Daftar Akun Baru
                    </a>
                </div>
            </div>
        </div>

    <?php elseif (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                </div>
                <h4 class="mb-3">Keranjang Anda Kosong</h4>
                <p class="text-muted mb-4">Ayo mulai belanja dan tambahkan produk ke keranjang Anda!</p>
                <a href="produk.php" class="btn btn-primary">
                    <i class="bi bi-shop me-2"></i>Lihat Produk
                </a>
            </div>
        </div>

    <?php else: ?>
        <?php include('config.php'); ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Produk</th>
                                        <th class="border-0 px-4 py-3">Jumlah</th>
                                        <th class="border-0 px-4 py-3">Harga</th>
                                        <th class="border-0 px-4 py-3">Total</th>
                                        <th class="border-0 px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_semua = 0;
                                    foreach ($_SESSION['keranjang'] as $id_produk => $quantity):
                                        $query = "SELECT * FROM produk WHERE id_produk = $id_produk";
                                        $result = mysqli_query($conn, $query);
                                        $product = mysqli_fetch_assoc($result);
                                        $total_semua += $product['harga'] * $quantity;
                                    $_SESSION['total_semua'] = $total_semua;
                                    ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/<?php echo $product['gambar']; ?>" 
                                                     class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="mb-0"><?php echo $product['nama']; ?></h6>
                                                    <small class="text-muted">SKU: <?php echo $product['id_produk']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3"><?php echo $quantity; ?></td>
                                        <td class="px-4 py-3">Rp. <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
                                        <td class="px-4 py-3">Rp. <?php echo number_format($total_semua, 0, ',', '.'); ?></td>
                                        <td class="px-4 py-3">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editModal"
                                                        data-id="<?php echo $id_produk; ?>"
                                                        data-quantity="<?php echo $quantity; ?>"
                                                        data-nama="<?php echo $product['nama']; ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-id="<?php echo $id_produk; ?>"
                                                        data-nama="<?php echo $product['nama']; ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga</span>
                            <span class="fw-bold">Rp. <?php echo number_format($total_semua, 0, ',', '.'); ?></span>
                        </div>
                        
                        <?php if($total_semua >= 30000): ?>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Diskon 50%</span>
                            <span class="fw-bold text-success">- Rp. <?php echo number_format($total_semua * 0.5, 0, ',', '.'); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Bayar</span>
                            <span class="fw-bold text-primary">Rp. <?php echo number_format($total_semua * 0.5, 0, ',', '.'); ?></span>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info small mb-3">
                            Belanja Rp. <?php echo number_format(30000 - $total_semua, 0, ',', '.'); ?> lagi untuk mendapatkan diskon 50%!
                        </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                <i class="bi bi-cart-check me-2"></i>Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="edit_keranjang.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Jumlah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_produk" id="editIdProduk">
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="hapus_item.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk <strong id="deleteProductName"></strong> dari keranjang?</p>
                    <input type="hidden" name="id_produk" id="deleteIdProduk">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-cart-check text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">Anda akan melakukan checkout untuk pesanan ini</h5>
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total Belanja:</strong>
                        <strong>Rp. <?php echo isset($total_semua) ? number_format($total_semua, 0, ',', '.') : '0'; ?></strong>
                    </div>
                    <?php if(isset($total_semua) && $total_semua >= 30000): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Diskon 50%:</strong>
                        <strong class="text-success">- Rp. <?php echo number_format($total_semua * 0.5, 0, ',', '.'); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total Bayar:</strong>
                        <strong class="text-primary">Rp. <?php echo number_format($total_semua * 0.5, 0, ',', '.'); ?></strong>
                    </div>
                    <?php endif; ?>
                </div>
                <p class="text-muted small mb-0">Dengan melanjutkan, Anda setuju untuk membeli produk sesuai dengan ketentuan yang berlaku.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <a href="pembayaran.php" class="btn btn-primary">
                    <i class="bi bi-cart-check me-2"></i>Ya, Checkout Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk mengisi modal edit dengan data produk
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const idProduk = button.getAttribute('data-id');
        const quantity = button.getAttribute('data-quantity');
        const namaProduk = button.getAttribute('data-nama');

        const modalTitle = editModal.querySelector('.modal-title');
        const inputIdProduk = editModal.querySelector('#editIdProduk');
        const inputQuantity = editModal.querySelector('#editQuantity');

        modalTitle.textContent = `Edit Jumlah Produk: ${namaProduk}`;
        inputIdProduk.value = idProduk;
        inputQuantity.value = quantity;
    });

    // Script untuk mengisi modal hapus dengan data produk
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const idProduk = button.getAttribute('data-id');
        const namaProduk = button.getAttribute('data-nama');

        const deleteProductName = deleteModal.querySelector('#deleteProductName');
        const inputIdProduk = deleteModal.querySelector('#deleteIdProduk');

        deleteProductName.textContent = namaProduk;
        inputIdProduk.value = idProduk;
    });
</script>

<?php include('includes/footer.php'); ?>