<?php
require_once 'models/AlatModel.php';

class PeminjamController {
    private $db;
    private $alatModel;

    public function __construct($db) {
        $this->db = $db;
        $this->alatModel = new AlatModel($db);
    }

    // Method Helper untuk menyimpan log aktivitas
    private function simpanLog($aksi, $keterangan) {
        $user_id = $_SESSION['user_id'] ?? 0; 
        $stmt = $this->db->prepare("INSERT INTO log_aktivitas (user_id, aksi, keterangan) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $aksi, $keterangan);
        $stmt->execute();
    }

    public function index() {
    // Ambil data dari database
    $result = $this->db->query("SELECT id, nama_alat, stok, status, foto FROM alat ORDER BY nama_alat ASC");
    
    // UBAH HASIL QUERY MENJADI ARRAY
    $daftarAlat = [];
    while ($row = $result->fetch_assoc()) {
        $daftarAlat[] = $row;
    }

    // Kirim $daftarAlat (yang sekarang sudah berbentuk array) ke view
    require_once 'views/peminjam/dashboard.php';
}
    public function formAjukan() {
        $id = isset($_POST['alat_id']) ? $_POST['alat_id'] : null;

        if ($id) {
            $alat = $this->alatModel->getAlatById($id);

            if ($alat) {
                require 'views/peminjam/ajukan.php';
            } else {
                die("Error: Data alat tidak ditemukan di database untuk ID: " . $id);
            }
        } else {
            header("Location: index.php?page=dashboard");
        }
    }

    public function simpanPengajuan() {
        $user_id = $_SESSION['user_id'];
        $alat_id = $_POST['alat_id'];
        $tgl_pinjam = $_POST['tanggal_pinjam'];
        $tgl_seharusnya = $_POST['tanggal_kembali_seharusnya'];

        // 1. Mulai Transaksi
        $this->db->begin_transaction();

        try {
            // 2. CEK STOK ASLI DI DATABASE DULU
            $cekAlat = $this->db->query("SELECT nama_alat, stok FROM alat WHERE id = $alat_id FOR UPDATE");
            $dataAlat = $cekAlat->fetch_assoc();

            if ($dataAlat['stok'] <= 0) {
                throw new Exception("stok_habis");
            }

            // 3. Simpan data peminjaman
            $stmt = $this->db->prepare("INSERT INTO peminjaman (user_id, alat_id, tanggal_pinjam, tanggal_kembali_seharusnya, status_pinjam) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->bind_param("iiss", $user_id, $alat_id, $tgl_pinjam, $tgl_seharusnya);
            $stmt->execute();

            // 4. Kurangi stok alat secara manual
            $this->db->query("UPDATE alat SET stok = stok - 1 WHERE id = $alat_id");

            // 5. Update status alat jika stok jadi 0
            $this->db->query("UPDATE alat SET status = 'kosong' WHERE id = $alat_id AND stok <= 0");

            // --- TAMBAHKAN LOG DI SINI ---
            $nama_alat = $dataAlat['nama_alat'];
            $this->simpanLog("Ajukan Peminjaman", "Peminjam mengajukan alat: $nama_alat (ID: $alat_id) untuk tanggal: $tgl_pinjam");

            $this->db->commit();
            header("Location: index.php?page=dashboard&pesan=berhasil_pinjam");
            exit();

        } catch (Exception $e) {
            $this->db->rollback();
            
            // Log kegagalan jika perlu (opsional)
            if ($e->getMessage() == "stok_habis") {
                $this->simpanLog("Gagal Pinjam", "Gagal meminjam alat ID: $alat_id karena stok habis tiba-tiba.");
            }

            $pesan = ($e->getMessage() == "stok_habis") ? "gagal_stok" : "gagal_sistem";
            header("Location: index.php?page=dashboard&pesan=" . $pesan);
            exit();
        }
    }
}