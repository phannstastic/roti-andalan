<?php
include('config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tlp_pengguna = $_POST['tlp_pengguna'];
    $digits_only = preg_replace('/\D/', '', $tlp_pengguna);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $error_message = "Password dan Confirm Password tidak cocok.";
    } elseif (!preg_match('/^[0-9\+\-\s]+$/', $tlp_pengguna)) {
        $error_message = "Nomor telepon hanya boleh berisi angka dan simbol +.";
    } elseif (strlen($digits_only) < 12) {
        $error_message = "Nomor telepon harus minimal 12 angka.";
    }else {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM pengguna WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Username atau Email sudah terdaftar.";
        } else {
            $insert = "INSERT INTO pengguna (username, email, password, tlp_pengguna) VALUES ('$username', '$email', '$passwordHashed', '$tlp_pengguna')";
            if (mysqli_query($conn, $insert)) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Terjadi kesalahan, silakan coba lagi.";
            }
        }
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/logo.png" alt="Logo" class="auth-logo">
            <h2>Buat Akun Baru</h2>
            <p class="text-muted">Daftar untuk mulai berbelanja</p>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form id="registerForm" action="register.php" method="POST" class="auth-form">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="tlp_pengguna" name="tlp_pengguna" placeholder="Nomor Telepon" pattern = "[0-9+ ]*" title = "Hanya angka dan simbol +" required>
                <label for="tlp_pengguna">Nomor Telepon</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="confirmPassword" required>
                <label for="confirmPassword">Confirm Password</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Daftar
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="mb-0">Sudah punya akun? 
                    <a href="login.php" class="text-primary text-decoration-none">Login sekarang</a>
                </p>
            </div>
        </form>
    </div>
</div>

<style>
.auth-container {
    min-height: calc(100vh - 56px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 2rem;
}

.auth-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding: 2rem;
    width: 100%;
    max-width: 420px;
    transition: transform 0.3s ease;
}

.auth-card:hover {
    transform: translateY(-5px);
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo {
    width: 80px;
    height: 80px;
    object-fit: contain;
    margin-bottom: 1.5rem;
}

.auth-form .form-control {
    border-radius: 0.5rem;
    font-size: 1rem;
    padding: 0.75rem 1rem;
}

.auth-form .form-floating label {
    padding-left: 1rem;
}

.auth-form .btn {
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.auth-form .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.alert {
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 576px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-card {
        padding: 1.5rem;
    }
}
</style>

<script>
    document.getElementById('tlp_pengguna').addEventListener('input', function (e)) {
        this.value = this.value.replace(/[^0-9+ ]/g, '');
        if (phone.length < 12) {
            e.preventDefault();
            alert('Nomor telepon harus terdiri dari minimal 12 angka!');
            return;
        }
    }
//     document.getElementById('registerForm').addEventListener('submit', function(e) {
//     const password = document.getElementById('password').value;
//     const confirmPassword = document.getElementById('confirm-password').value;

//     if (password !== confirmPassword) {
//         e.preventDefault(); // Mencegah form submit
//         alert('Password dan Confirm Password tidak cocok!');
//     }
// });
</script>
<?php include('includes/footer.php'); ?>