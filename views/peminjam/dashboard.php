<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            --bg-light: #f4f7fe;
        }
        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: #2d3436;
        }
        .container { margin-top: 40px; margin-bottom: 60px; }
        
        /* Glassmorphism Header */
        .header-dashboard {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: 0.3s ease;
        }
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid #f1f1f1;
            padding: 20px;
        }

        /* Tool Image Custom */
        .img-alat {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 12px;
            transition: 0.3s;
        }
        .img-alat:hover { transform: scale(1.1); }

        /* Badge Custom */
        .badge-status {
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modern Table */
        .table { vertical-align: middle; }
        .table thead th {
            background: #f8f9fa;
            color: #636e72;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            border: none;
            padding: 15px;
        }
        .table tbody td { padding: 15px; border-bottom: 1px solid #f8f9fa; }

        .btn-pinjam {
            background: var(--primary-gradient);
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }
        
        /* Status Tracking Dots */
        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-dashboard d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="bg-primary bg-gradient text-white rounded-4 p-3 me-4 shadow-sm">
                <i class="bi bi-person-badge fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">Halo, <?= $_SESSION['nama']; ?> 👋</h3>
                <p class="text-muted mb-0 small">Siap untuk meminjam peralatan hari ini?</p>
            </div>
        </div>
        <a href="index.php?page=logout" class="btn btn-light text-danger fw-bold border-0 px-4 py-2 shadow-sm rounded-3">
            <i class="bi bi-power me-2"></i>Keluar
        </a>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-dismissible fade show shadow-sm border-0 rounded-4 p-3 <?= $_GET['pesan'] == 'berhasil_pinjam' ? 'alert-success bg-white text-success' : 'alert-danger bg-white text-danger' ?>" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi <?= $_GET['pesan'] == 'berhasil_pinjam' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> fs-4 me-3"></i>
                <div>
                    <strong><?= $_GET['pesan'] == 'berhasil_pinjam' ? 'Sukses!' : 'Opps!' ?></strong> 
                    <?= $_GET['pesan'] == 'berhasil_pinjam' ? 'Pengajuan terkirim. Mohon tunggu verifikasi petugas.' : 'Stok barang tidak mencukupi.' ?>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-archive me-2 text-primary"></i>Katalog Alat</h5>
                    <span class="badge bg-primary-subtle text-primary border rounded-pill">Total: <?= count($daftarAlat); ?> Unit</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table hover mb-0">
                            <tbody>
    <?php foreach ($daftarAlat as $alat): ?>
    <tr>
        <td class="ps-4">
            <div class="d-flex align-items-center">
                <?php 
                // 1. Samakan folder dengan Admin: assets/img/alat/
                // 2. Samakan nama kolom dengan database: 'foto'
                $gambarPath = 'assets/img/alat/' . $alat['foto'];
                
                // Cek apakah file benar-benar ada di folder, jika tidak tampilkan default
                if (!empty($alat['foto']) && file_exists($gambarPath)) {
                    $tampilFoto = $gambarPath;
                } else {
                    $tampilFoto = 'assets/img/alat/default.jpg'; 
                }
                ?>
                
                <img src="<?= $tampilFoto; ?>" 
                     class="img-alat me-3 shadow-sm border" 
                     alt="tool" 
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                
                <div>
                    <div class="fw-bold text-dark"><?= $alat['nama_alat']; ?></div>
                    <div class="text-muted" style="font-size: 0.75rem;">ID: #AL-<?= str_pad($alat['id'], 3, '0', STR_PAD_LEFT); ?></div>
                </div>
            </div>
        </td>
        <td class="text-center">
            <div class="fw-bold"><?= $alat['stok']; ?> <small class="text-muted fw-normal">Pcs</small></div>
        </td>
        <td class="text-center pe-4">
            <?php if ($alat['stok'] > 0): ?>
                <form action="index.php?page=ajukan-pinjam" method="POST">
                    <input type="hidden" name="alat_id" value="<?= $alat['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm btn-pinjam">
                        Pinjam Alat
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-light btn-sm text-muted rounded-3" disabled>Habis</button>
            <?php endif; ?>
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
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Saya</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        global $db; 
                        $user_id = $_SESSION['user_id'] ?? null;
                        if ($user_id) {
                            $query = "SELECT p.*, a.nama_alat FROM peminjaman p JOIN alat a ON p.alat_id = a.id WHERE p.user_id = $user_id ORDER BY p.id DESC LIMIT 6";
                            $result = $db->query($query);

                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $statusClass = 'text-warning'; 
                                    $bgStatus = 'bg-warning';

$badgeColor = 'warning'; 
if($row['status_pinjam'] == 'disetujui') $badgeColor = 'success';
if($row['status_pinjam'] == 'kembali') $badgeColor = 'info';
if($row['status_pinjam'] == 'ditolak') $badgeColor = 'danger';
                        ?>
                        <li class="list-group-item p-3 border-0 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="fw-bold text-dark"><?= $row['nama_alat']; ?></span>
                                <span class="badge <?= $bgStatus; ?> bg-opacity-10 <?= $statusClass; ?> rounded-pill" style="font-size: 0.65rem;">
                                    <?= strtoupper($row['status_pinjam']); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?></small>
                                <?php if($row['denda'] > 0): ?>
                                    <small class="text-danger fw-bold">Denda: Rp<?= number_format($row['denda'], 0, ',', '.'); ?></small>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php 
                                }
                            } else {
                                echo "<div class='p-4 text-center text-muted'><i class='bi bi-inbox fs-2 d-block mb-2'></i>Belum ada aktivitas.</div>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="card-footer text-center bg-white">
                    <a href="index.php?page=riwayat-lengkap" class="small text-decoration-none fw-bold">Lihat Semua Riwayat →</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>