<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --primary-color: #2563eb;
        --bg-light: #f9fafb;
        --text-dark: #1f2937;
        --text-muted: #6b7280;
    }

    body { 
        font-family: 'Inter', sans-serif; 
        background-color: var(--bg-light); 
        color: var(--text-dark);
    }

    /* Card Styling */
    .card-custom {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    /* Table Styling */
    .table thead th { 
        background-color: #fcfcfd; 
        text-transform: uppercase; 
        font-size: 0.7rem; 
        font-weight: 700;
        letter-spacing: 0.05em; 
        color: var(--text-muted);
        border-bottom: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
    }

    .table tbody td {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }

    /* Icon Container */
    .icon-box {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #eff6ff;
        border-radius: 10px;
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    /* Buttons */
    .btn { 
        padding: 0.6rem 1.2rem;
        border-radius: 10px; 
        font-weight: 500; 
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-action {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    /* Status Badge */
    .badge-status {
        padding: 0.5em 1em;
        border-radius: 99px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    /* Modal Styling */
    .modal-content { 
        border: none; 
        border-radius: 20px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .form-control { 
        border-radius: 10px; 
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        background-color: #f9fafb;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
</style>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h2 class="fw-bold tracking-tight mb-1">Inventaris Alat</h2>
            <p class="text-muted">Kelola aset dan ketersediaan peralatan dalam satu panel terpusat.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlat">
                <a href="#modalTambahAlat" class="bi bi-plus-lg me-2" >Tambah Alat </a>
            </button>
        </div>
    </div>

    <div class="card-custom shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
    <thead>
        <tr>
            <th>Detail Alat</th>
            <th>Stok</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $alat->fetch_assoc()): ?>
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="assets/img/alat/<?= $row['foto']; ?>" 
                             alt="foto" 
                             class="rounded shadow-sm border" 
                             style="width: 50px; height: 50px; object-fit: cover;">
                    </div>
                    <div>
                        <div class="fw-bold text-dark"><?= $row['nama_alat']; ?></div>
                        <div class="text-muted small">ID Alat: #<?= $row['id']; ?></div>
                    </div>
                </div>
            </td>
            <td>
                <span class="fw-semibold"><?= $row['stok']; ?></span> <span class="text-muted small">Unit</span>
            </td>
            <td>
                <?php if($row['status'] == 'tersedia'): ?>
                    <span class="badge-status bg-success-subtle text-success">
                        <i class="bi bi-dot"></i> Tersedia
                    </span>
                <?php else: ?>
                    <span class="badge-status bg-danger-subtle text-danger">
                        <i class="bi bi-dot"></i> Stok Habis
                    </span>
                <?php endif; ?>
            </td>
            <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-light btn-action" data-bs-toggle="modal" data-bs-target="#modalEditAlat<?= $row['id']; ?>">
                        <i class="bi bi-pencil-square text-primary"></i>
                    </button>
                    
                    <a href="index.php?page=hapus-alat&id=<?= $row['id']; ?>" class="btn btn-light btn-action" onclick="return confirm('Hapus alat ini?')" title="Hapus">
                        <i class="bi bi-trash3 text-danger"></i>
                    </a>
                </div>

                <div class="modal fade" id="modalEditAlat<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="index.php?page=update-alat" method="POST" enctype="multipart/form-data" class="modal-content text-start">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold">Edit Informasi Alat</h5>
                            </div>
                            <div class="modal-body py-4">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">NAMA ALAT</label>
                                    <input type="text" name="nama_alat" class="form-control" value="<?= $row['nama_alat']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">GANTI FOTO (OPSIONAL)</label>
                                    <input type="file" name="foto" class="form-control">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-muted small fw-bold">JUMLAH STOK</label>
                                    <input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>" min="0" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAlat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="index.php?page=simpan-alat" method="POST" enctype="multipart/form-data" class="modal-content">
    <div class="modal-body">
        <div class="mb-3">
            <label>Nama Alat</label>
            <input type="text" name="nama_alat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Foto Alat</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label>Jumlah Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
</div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Alat</button>
    </div>
    <a href="index.php?page=dashboard" class="btn btn-link text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
        </form>
</form>
    </div>
</div>