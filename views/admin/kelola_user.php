<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    #user-management-page {
        background-color: #f8f9fa;
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding-bottom: 3rem;
    }

    /* Header Styling */
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title h2 {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.2rem;
    }

    /* Card & Table Styling */
    .table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .custom-table thead th {
        background: #fbfbfc;
        padding: 1.25rem 1.5rem;
        color: #888ea8;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        border-bottom: 1px solid #f1f2f3;
    }

    .custom-table tbody td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f2f3;
        color: #3b3f5c;
    }

    /* User Info Styling */
    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .username-text {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0;
        display: block;
    }

    /* Badge Roles */
    .badge-role {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .role-petugas { background: #e0e7ff; color: #4338ca; }
    .role-peminjam { background: #f3f4f6; color: #6b7280; }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-circle {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        text-decoration: none;
    }

    .btn-edit:hover { background: #fffbeb; color: #d97706; border-color: #fcd34d; }
    .btn-delete:hover { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; padding: 10px; }
    .modal-header { border: none; padding-bottom: 0; }
    .modal-footer { border: none; }
    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
    }
</style>

<div id="user-management-page" class="container py-5">
    <div class="header-container">
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="index.php?page=simpan-user" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Pengguna Baru</h5>
               
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Role / Hak Akses</label>
                    <select name="role" class="form-select" required>
                        <option value="" selected disabled>Pilih Role</option>
                        <option value="peminjam">Peminjam</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan User</button>
            </div>
        </form>
    </div>
</div>
       
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 40%">Informasi Pengguna</th>
                        <th style="width: 30%">Level Akses</th>
                        <th class="text-center" style="width: 30%">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($row['username'], 0, 1)); ?>
                                </div>
                                <div>
                                    <span class="username-text"><?= $row['username']; ?></span>
                                    <small class="text-muted">UID-<?= $row['id']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($row['role'] == 'petugas'): ?>
                                <span class="badge-role role-petugas">
                                    <i class="bi bi-shield-lock-fill"></i> Petugas
                                </span>
                            <?php else: ?>
                                <span class="badge-role role-peminjam">
                                    <i class="bi bi-person-fill"></i> Peminjam
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns">
                               <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="index.php?page=update-user" method="POST" class="modal-content shadow-lg">
                                <div class="modal-header px-4 pt-4">
                                    <h5 class="fw-bold">Edit Pengguna</h5>
                                    
                                </div>
                                <div class="modal-body p-4">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= $row['username']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Ganti Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin ganti">
                                    </div>
                                    
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Role Akses</label>
                                        <select name="role" class="form-select" required>
                                            <option value="peminjam" <?= $row['role'] == 'peminjam' ? 'selected' : ''; ?>>Peminjam</option>
                                            <option value="petugas" <?= $row['role'] == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer p-4 pt-0">
                                    <button type="button" class="btn btn-light px-4" style="border-radius: 12px;" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 12px; background: #4338ca;">Update Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                                <a href="index.php?page=hapus-user&id=<?= $row['id']; ?>" 
                                   class="btn-circle btn-delete" 
                                   onclick="return confirm('Hapus user ini?')">
                                    <i class="bi bi-trash3-fill">hapus</i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="index.php?page=dashboard" class="btn btn-link text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>
</div>