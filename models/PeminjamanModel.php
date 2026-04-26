<?php
class PeminjamanModel {
    private $conn;
    private $table = "peminjaman";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function hitungDenda($id_peminjaman, $tgl_kembali_real) {
        $query = "SELECT tgl_kembali FROM " . $this->table . " WHERE id_peminjaman = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_peminjaman]);
        $data = $stmt->fetch();

        $tgl_seharusnya = strtotime($data['tgl_kembali']);
        $tgl_fisik = strtotime($tgl_kembali_real);
        
        $selisih = ($tgl_fisik - $tgl_seharusnya) / (60 * 60 * 24);
        $denda = 0;

        if ($selisih > 0) {
            $denda = $selisih * 5000; // Rp 5.000 per hari
        }
        return $denda;
    }

    public function kembalikanAlat($id_peminjaman) {
        $tgl_sekarang = date('Y-m-d');
        $denda = $this->hitungDenda($id_peminjaman, $tgl_sekarang);

        $query = "UPDATE " . $this->table . " SET tgl_realisasi_kembali = ?, denda = ?, status = 'Dikembalikan' WHERE id_peminjaman = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$tgl_sekarang, $denda, $id_peminjaman]);
    }
    // Tambahkan ini di dalam class PeminjamanModel
public function cekStok($id_alat) {
    $query = "SELECT stok FROM alat WHERE id_alat = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id_alat]);
    $row = $stmt->fetch();
    return $row['stok'];
}

public function buatPengajuan($id_user, $id_alat, $tgl_pinjam, $tgl_kembali) {
    $query = "INSERT INTO peminjaman (id_user, id_alat, tgl_pinjam, tgl_kembali, status) 
              VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$id_user, $id_alat, $tgl_pinjam, $tgl_kembali]);
}
}