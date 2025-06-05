<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna berdasarkan username
    $query = "SELECT * FROM pengguna WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data pengguna ke session
        $_SESSION['user'] = $user['username'];

        // Cek apakah pengguna adalah admin
        if ($user['role'] == 'admin') {
            $_SESSION['admin'] = true;
            header("Location: admin.php");  // Arahkan ke halaman admin
        } else {
            $_SESSION['admin'] = false;
            header("Location: index.php");  // Arahkan ke halaman pengguna
        }
        exit();
    } else {
        $error_message = "Username atau password salah!";
    }

    // $captcha_response = $_POST['g-recaptcha-response'];

    // // Verify CAPTCHA
    // $captcha_secret_key = '6LfY3qcqAAAAAMfLLpLfrsIwHLCoTIMw5Kbr-l-y';
    // $captcha_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    // $captcha_verify_data = [
    //     'secret' => $captcha_secret_key,
    //     'response' => $captcha_response
    // ];
    // $captcha_verify_options = [
    //     'http' => [
    //         'method' => 'POST',
    //         'content' => http_build_query($captcha_verify_data),
    //         'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
    //     ]
    // ];
    // $captcha_verify_context = stream_context_create($captcha_verify_options);
    // $captcha_verify_response = file_get_contents($captcha_verify_url, false, $captcha_verify_context);
    // $captcha_result = json_decode($captcha_verify_response);

    // if (!$captcha_result->success) {
    //     $error_message = "Captcha verification failed. Please try again.";
    // } else {
    //     $query = "SELECT * FROM pengguna WHERE username = '$username' OR email = '$username'";
    //     $result = mysqli_query($conn, $query);

    //     if (mysqli_num_rows($result) > 0) {
    //         $user = mysqli_fetch_assoc($result);
    //         if (password_verify($password, $user['password'])) {
    //             $_SESSION['user'] = $user['username'];
    //             $_SESSION['id_pengguna'] = $user['id'];
    //             header("Location: akun.php");
    //             exit();        
    //         } else {
    //             $error_message = "Password salah.";
    //         }
    //     } else {
    //         $error_message = "Username atau Email tidak ditemukan.";
    //     }
    // }
}
?>

<?php include('includes/header.php'); ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/logo.png" alt="Logo" class="auth-logo">
            <h2>Selamat Datang 🤗</h2>
            <p class="text-muted">Silakan login untuk melanjutkan</p>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username atau Email" required>
                <label for="username">Username atau Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LfY3qcqAAAAALTAu3H8DfxWkUY_xTxMKo11lmkN"></div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="mb-0">Belum punya akun? 
                    <a href="register.php" class="text-primary text-decoration-none">Daftar sekarang</a>
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

<?php include('includes/footer.php'); ?>

<!-- Google reCAPTCHA script
<script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
