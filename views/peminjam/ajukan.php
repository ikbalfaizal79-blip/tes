<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-plus me-2"></i>Formulir Pengajuan Peminjaman</h5>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?page=proses-ajukan" method="POST">
                        <input type="hidden" name="alat_id" value="<?= $alat['id']; ?>">

                       <div class="mb-3">
    <label class="form-label fw-bold">Stok Tersedia</label>
    <input type="text" class="form-control" value="<?= $alat['stok']; ?>" disabled>
</div>
<div class="row">
                            <form action="index.php?page=simpan-pengajuan" method="POST">
    <input type="hidden" name="alat_id" value="<?= $alat['id']; ?>">
    
    <div class="mb-3">
        <label class="form-label fw-bold">Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Rencana Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali_seharusnya" class="form-control" required>
        <div class="form-text text-danger">*Denda Rp 20.000/hari jika terlambat.</div>
    </div>
    <div class="alert alert-warning border-0 small">
                            <strong><i class="bi bi-exclamation-triangle-fill"></i> Aturan Denda:</strong><br>
                            Keterlambatan pengembalian akan dikenakan denda otomatis yang dihitung oleh petugas saat barang dikembalikan.
                        </div>

    <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
</form>
                        </div>

                        



                        

                        <div class="d-grid gap-2">
                           
                            <a href="index.php?page=dashboard" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>