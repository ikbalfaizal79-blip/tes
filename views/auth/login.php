<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .auth-card { max-width: 400px; margin: 100px auto; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .nav-pills .nav-link.active { background-color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <div class="card auth-card bg-white">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Inventory App</h3>
            
            <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login">Login</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register">Daftar</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-login">
                    <?php if(isset($_GET['error'])) echo '<div class="alert alert-danger p-2 small">Username/Password Salah!</div>'; ?>
                    <?php if(isset($_GET['success'])) echo '<div class="alert alert-success p-2 small">Akun berhasil dibuat! Silahkan login.</div>'; ?>
                    
                    <form action="index.php?page=proses-login" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Masuk Sekarang</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="pills-register">
                    <form action="index.php?page=proses-register" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Buat Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username baru" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Buat Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Buat Akun</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
