<style>
    /* Custom CSS untuk mempercantik detail */
    .log-container { background: #f8f9fa; min-height: 100vh; font-family: 'Inter', sans-serif; }
    .card-log { border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); }
    .table thead th { 
        background-color: #ffffff; 
        color: #6c757d; 
        font-weight: 600; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px;
        border-bottom: 1px solid #f0f0f0;
    }
    .user-avatar {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        border-radius: 10px;
        font-weight: bold;
        font-size: 0.85rem;
    }
    .badge-soft {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .row-hover:hover { background-color: #fcfcfc !important; transition: 0.3s; }
</style>

<div class="log-container py-5">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold text-dark m-0">Aktivitas Sistem</h3>
                <p class="text-muted small mb-0">Monitor setiap perubahan data secara real-time</p>
            </div>
            <a href="index.php?page=dashboard" class="btn btn-link text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard</a>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-white shadow-sm border" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh Log
                </button>
            </div>
        </div>

        <div class="card card-log shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Timestamp</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Detail Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($logs->num_rows > 0): ?>
                            <?php while($row = $logs->fetch_assoc()): ?>
                            <tr class="row-hover">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-1">
                                            <div class="text-dark fw-semibold" style="font-size: 0.9rem;">
                                                <?= date('d M Y', strtotime($row['tanggal'])); ?>
                                            </div>
                                            <div class="text-muted" style="font-size: 0.8rem;">
                                                <?= date('H:i:s', strtotime($row['tanggal'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3 shadow-sm">
                                            <?= strtoupper(substr($row['username'] ?? 'S', 0, 1)); ?>
                                        </div>
                                        <span class="text-dark fw-medium"><?= $row['username'] ?? 'System Admin'; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        // Variasi warna badge yang elegan
                                        $aksi = strtolower($row['aksi']);
                                        $style = "bg-secondary text-white"; // default
                                        if(strpos($aksi, 'tambah') !== false) $style = "bg-success-subtle text-success";
                                        else if(strpos($aksi, 'hapus') !== false) $style = "bg-danger-subtle text-danger";
                                        else if(strpos($aksi, 'edit') !== false || strpos($aksi, 'update') !== false) $style = "bg-primary-subtle text-primary";
                                        else if(strpos($aksi, 'login') !== false) $style = "bg-warning-subtle text-warning";
                                    ?>
                                    <span class="badge-soft <?= $style ?>">
                                        <i class="bi bi-dot"></i> <?= ucfirst($row['aksi']); ?>
                                    </span>
                                </td>
                                <td class="text-muted" style="font-size: 0.875rem; max-width: 300px;">
                                    <div class="text-truncate" title="<?= $row['keterangan']; ?>">
                                        <?= $row['keterangan']; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="opacity-50 mb-3 fs-1">📂</div>
                                    <h6 class="text-muted fw-light">Tidak ada rekaman aktivitas ditemukan.</h6>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3 text-center">
                <small class="text-muted italic">Data diperbarui secara otomatis oleh server</small>
            </div>
             
        </div>
    </div>
</div>