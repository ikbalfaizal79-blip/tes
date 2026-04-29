<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Dashboard - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #198754;
            --secondary-bg: #f0f2f5;
        }
        body { background-color: var(--secondary-bg); font-family: 'Inter', sans-serif; }
        .navbar-custom { background-color: var(--primary-color); }
        .card { border: none; border-radius: 12px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .stat-icon { font-size: 2.5rem; opacity: 0.3; position: absolute; right: 15px; bottom: 10px; }
        .table thead { background-color: #f8f9fa; }
        .badge-status { font-weight: 500; padding: 0.5em 0.8em; }
        .section-title { border-left: 4px solid var(--primary-color); padding-left: 10px; margin-bottom: 20px; font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-shield-check-fill me-2"></i> INVENTORY SYSTEM</a>
        <div class="navbar-nav ms-auto align-items-center">
            <span class="nav-link active me-3">
                <i class="bi bi-person-circle"></i> <?= $_SESSION['nama']; ?> (Petugas)
            </span>
            <a class="btn btn-light btn-sm fw-bold text-success" href="index.php?page=logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    // Logika Pengambilan Data
    $jumlahPending = $db->query("SELECT COUNT(*) as total FROM peminjaman WHERE status_pinjam = 'pending'")->fetch_assoc()['total'];
    $jumlahBerjalan = $db->query("SELECT COUNT(*) as total FROM peminjaman WHERE status_pinjam = 'disetujui'")->fetch_assoc()['total'];
    ?>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'selesai'): ?>
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
        <div>
            <strong>Berhasil!</strong> Barang telah dikembalikan.
            <?php if ($_GET['denda'] > 0): ?>
                <span class="badge bg-danger ms-2">Denda: Rp <?= number_format($_GET['denda'], 0, ',', '.'); ?></span>
            <?php endif; ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm bg-white border-start border-primary border-5">
                <div class="card-body p-4">
                    <p class="text-muted text-uppercase small fw-bold mb-1">Menunggu Persetujuan</p>
                    <h2 class="display-6 fw-bold mb-0"><?= $jumlahPending; ?></h2>
                    <i class="bi bi-hourglass-split stat-icon text-primary"></i>
                    <a href="#tabel-pending" class="stretched-link text-decoration-none small">Tinjau Permintaan →</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm bg-white border-start border-success border-5">
                <div class="card-body p-4">
                    <p class="text-muted text-uppercase small fw-bold mb-1">Peminjaman Berjalan</p>
                    <h2 class="display-6 fw-bold mb-0"><?= $jumlahBerjalan; ?></h2>
                    <i class="bi bi-truck stat-icon text-success"></i>
                    <a href="#tabel-berjalan" class="stretched-link text-decoration-none small text-success">Pantau Pengembalian →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4" id="tabel-pending">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars me-2"></i>Permintaan Peminjaman</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Alat/Barang</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $db->query("SELECT p.id, u.username, a.nama_alat FROM peminjaman p JOIN users u ON p.user_id = u.id JOIN alat a ON p.alat_id = a.id WHERE p.status_pinjam = 'pending'");
                            if($res->num_rows == 0) echo "<tr><td colspan='3' class='text-center py-4 text-muted'>Tidak ada permintaan baru</td></tr>";
                            while($row = $res->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="fw-bold"><?= $row['username'] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $row['nama_alat'] ?></span></td>
                                <td class="text-center">
                                    <form action="index.php?page=acc-peminjaman" method="POST">
                                        <input type="hidden" name="id_peminjaman" value="<?= $row['id'] ?>">
                                        <button class="btn btn-success btn-sm px-3 shadow-sm"><i class="bi bi-check2-circle"></i> Setujui</button>
                                    </form>
                                </td>
                                <td>


    <form action="index.php?page=tolak-peminjaman" method="POST" style="display:inline;">
        <input type="hidden" name="id_peminjaman" value="<?= $row['id']; ?>">
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Tolak</button>
    </form>
</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mb-4" id="tabel-berjalan">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-arrow-repeat me-2"></i>Peminjaman Aktif</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $db->query("SELECT p.id, u.username, a.nama_alat FROM peminjaman p JOIN users u ON p.user_id = u.id JOIN alat a ON p.alat_id = a.id WHERE p.status_pinjam = 'disetujui'");
                            if($res->num_rows == 0) echo "<tr><td colspan='3' class='text-center py-4 text-muted'>Tidak ada peminjam aktif</td></tr>";
                            while($row = $res->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $row['username'] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $row['nama_alat'] ?></span></td>
                                <td class="text-center">
                                    <form action="index.php?page=proses-kembali" method="POST">
                                        <input type="hidden" name="id_peminjaman" value="<?= $row['id'] ?>">
                                        <button class="btn btn-outline-primary btn-sm px-3 shadow-sm"><i class="bi bi-box-arrow-in-down"></i> Selesaikan</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Baru Saja Kembali</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php
                        $res = $db->query("SELECT p.*, u.username, a.nama_alat FROM peminjaman p JOIN users u ON p.user_id = u.id JOIN alat a ON p.alat_id = a.id WHERE p.status_pinjam = 'kembali' ORDER BY p.tanggal_kembali_realitas DESC LIMIT 5");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold"><?= $row['username']; ?></div>
                                    <small class="text-muted"><?= $row['nama_alat']; ?></small>
                                </div>
                                <?php if($row['denda'] > 0): ?>
                                    <span class="badge bg-danger">Rp <?= number_format($row['denda'], 0, ',', '.'); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Selesai</span>
                                <?php endif; ?>
                            </div>
                            <small class="d-block mt-2 text-muted italic" style="font-size: 0.75rem;">
                                Kembali: <?= date('d M Y', strtotime($row['tanggal_kembali_realitas'])); ?>
                            </small>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="index.php?page=riwayat-lengkap" class="text-decoration-none small fw-bold">Lihat Semua Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>