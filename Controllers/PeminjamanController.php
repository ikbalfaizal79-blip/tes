<?php
require_once '../Models/PeminjamanModel.php';

class PeminjamanController {
    private $model;

    public function __construct($db) {
        $this->model = new PeminjamanModel($db);
    }

    // Fitur: Mengajukan Peminjaman
    public function ajukan($id_user, $id_alat, $tgl_kembali) {
        $tgl_pinjam = date('Y-m-d');
        
        // Cek apakah stok alat masih ada sebelum memproses
        if ($this->model->cekStok($id_alat) > 0) {
            $result = $this->model->buatPengajuan($id_user, $id_alat, $tgl_pinjam, $tgl_kembali);
            return $result ? "Berhasil diajukan!" : "Gagal mengajukan.";
        }
        return "Stok alat habis.";
    }

    // Fitur: Mengembalikan Alat
    public function kembalikan($id_peminjaman) {
        $result = $this->model->kembalikanAlat($id_peminjaman);
        if ($result) {
            return "Alat berhasil dikembalikan.";
        }
        return "Gagal memproses pengembalian.";
    }
}