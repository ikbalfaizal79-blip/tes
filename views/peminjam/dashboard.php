<?php
// Pastikan session sudah dimulai di index atau controller
// if($_SESSION['role'] !== 'Peminjam') { header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Peminjam | App Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand" href="#">LalaBorrow <span class="badge bg-info text-dark" style="font-size: 0.7em;">Peminjam</span></a>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white me-3">Halo, Peminjam!</span>
            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Daftar Alat Tersedia</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Proyektor Epson EB-X400</td>
                                <td>Elektronik</td>
                                <td><span class="badge bg-success">5 Tersedia</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                                        <i class="bi bi-plus-circle me-1"></i>Pinjam
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-warning mb-3">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Status Peminjaman</h6>
                    <h4 class="mb-0">2 Alat <small class="text-muted" style="font-size: 0.6em;">sedang dipinjam</small></h4>
                </div>
            </div>
            
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Tagihan Denda</h6>
                    <h4 class="text-danger mb-0">Rp 0</h4>
                    <p class="small text-muted mt-2 mb-0">*Terhitung jika terlambat mengembalikan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Pinjaman Aktif Kamu</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Alat</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                    <th>Denda Saat Ini</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kamera Canon EOS</td>
                                    <td>01-04-2026</td>
                                    <td>08-04-2026</td>
                                    <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
                                    <td class="text-danger fw-bold">Rp 5.000</td>
                                    <td>
                                        <form action="proses_kembali.php" method="POST">
                                            <input type="hidden" name="id_pinjam" value="1">
                                            <button type="submit" class="btn btn-outline-success btn-sm">Kembalikan</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pengajuan Pinjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_pinjam.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" class="form-control" value="Proyektor Epson EB-X400" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali" class="form-control" required>
                        <div class="form-text text-danger">Denda Rp 5.000/hari jika telat.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>