<?php
// Pastikan variabel koneksi $db sudah tersedia
global $db;

// 1. Hitung Total Alat
$qAlat = $db->query("SELECT COUNT(*) as total FROM alat");
$totalAlat = $qAlat->fetch_assoc()['total'];

// 2. Hitung Peminjaman Aktif (Status 'disetujui')
$qAktif = $db->query("SELECT COUNT(*) as total FROM peminjaman WHERE status_pinjam = 'disetujui'");
$totalAktif = $qAktif->fetch_assoc()['total'];

// 3. Hitung Menunggu Persetujuan (Status 'pending')
$qPending = $db->query("SELECT COUNT(*) as total FROM peminjaman WHERE status_pinjam = 'pending'");
$totalPending = $qPending->fetch_assoc()['total'];

// 4. Hitung Total User (Semua kecuali admin jika ingin membedakan)
$qUser = $db->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
$totalUser = $qUser->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .nav-link { color: #c2c7d0; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.1); }
        .stat-card { border: none; border-radius: 10px; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block sidebar p-3">
            <h4 class="text-center mb-4">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="index.php?page=dashboard" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="index.php?page=kelola-user" class="nav-link"><i class="bi bi-people me-2"></i> Kelola User</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="index.php?page=kelola-alat" class="nav-link"><i class="bi bi-tools me-2"></i> Kelola Alat</a>
                </li>
               
                <li class="nav-item mb-2">
                    <a href="index.php?page=log-aktivitas" class="nav-link"><i class="bi bi-journal-text me-2"></i> Log Aktivitas</a>
                </li>
                <hr>
                <li class="nav-item">
                    <a href="index.php?page=logout" class="nav-link text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Ringkasan Statistik</h4>
                <span class="badge bg-primary px-3 py-2">Administrator: <?= $_SESSION['nama']; ?></span>
            </div>

            <div class="row">
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 border-0 shadow-sm">
            <h6>Total Alat</h6>
            <h2><?= $totalAlat; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white p-3 border-0 shadow-sm">
            <h6>Peminjaman Aktif</h6>
            <h2><?= $totalAktif; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white p-3 border-0 shadow-sm">
            <h6>Menunggu Persetujuan</h6>
            <h2><?= $totalPending; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 border-0 shadow-sm">
            <h6>Total User</h6>
            <h2><?= $totalUser; ?></h2>
        </div>
    </div>
</div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-hover">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>User</th>
            <th>Status</th> <th>Alat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Ambil data aktivitas terbaru (limit 5 atau 10)
        $qLog = $db->query("SELECT p.*, u.username, a.nama_alat 
                            FROM peminjaman p 
                            JOIN users u ON p.user_id = u.id 
                            JOIN alat a ON p.alat_id = a.id 
                            ORDER BY p.id DESC LIMIT 5");
        
        while($log = $qLog->fetch_assoc()):
            // Logika Warna Badge Status
            $statusLabel = ucfirst($log['status_pinjam']);
            $badgeColor = 'warning'; // default: pending

            if($log['status_pinjam'] == 'disetujui') {
                $badgeColor = 'success';
            } elseif($log['status_pinjam'] == 'ditolak') {
                $badgeColor = 'danger';
            } elseif($log['status_pinjam'] == 'kembali') {
                $badgeColor = 'info';
                $statusLabel = 'Selesai';
            }
        ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($log['tanggal_pinjam'])); ?></td>
            <td><?= $log['username']; ?></td>
            <td>
                <span class="badge bg-<?= $badgeColor; ?> rounded-pill px-3">
                    <?= $statusLabel; ?>
                </span>
            </td>
            <td><?= $log['nama_alat']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
