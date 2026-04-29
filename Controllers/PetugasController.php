<?php
class PetugasController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Method Helper untuk menyimpan log aktivitas
    private function simpanLog($aksi, $keterangan) {
        // Asumsi: Anda memiliki tabel 'log_aktivitas' dan menyimpan user_id dari session
        $user_id = $_SESSION['user_id'] ?? 0; 
        $stmt = $this->db->prepare("INSERT INTO log_aktivitas (user_id, aksi, keterangan) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $aksi, $keterangan);
        $stmt->execute();
    }

    

    public function accPeminjaman() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_peminjaman'];

            $stmt = $this->db->prepare("UPDATE peminjaman SET status_pinjam = 'disetujui' WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Tambahkan Log
                $this->simpanLog("Setujui Peminjaman", "Petugas menyetujui peminjaman dengan ID: $id");
                
                header("Location: index.php?page=dashboard&status=disetujui");
                exit();
            } else {
                echo "Gagal menyetujui: " . $this->db->error;
            }
        }
    }

    public function prosesKembali() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_peminjaman = $_POST['id_peminjaman'];
            $tgl_kembali_sekarang = date('Y-m-d');
            $denda_per_hari = 20000;

            $stmt = $this->db->prepare("SELECT alat_id, tanggal_kembali_seharusnya FROM peminjaman WHERE id = ?");
            $stmt->bind_param("i", $id_peminjaman);
            $stmt->execute();
            $data = $stmt->get_result()->fetch_assoc();

            $total_denda = 0;
            if (strtotime($tgl_kembali_sekarang) > strtotime($data['tanggal_kembali_seharusnya'])) {
                $selisih = strtotime($tgl_kembali_sekarang) - strtotime($data['tanggal_kembali_seharusnya']);
                $hari = floor($selisih / (60 * 60 * 24));
                $total_denda = $hari * $denda_per_hari;
            }

            $update = $this->db->prepare("UPDATE peminjaman SET tanggal_kembali_realitas = ?, status_pinjam = 'kembali', denda = ? WHERE id = ?");
            $update->bind_param("sii", $tgl_kembali_sekarang, $total_denda, $id_peminjaman);
            
            if ($update->execute()) {
                $this->db->query("UPDATE alat SET stok = stok + 1, status = 'tersedia' WHERE id = {$data['alat_id']}");
                
                // Tambahkan Log
                $this->simpanLog("Proses Pengembalian", "Alat ID: {$data['alat_id']} dikembalikan. Denda: Rp" . number_format($total_denda, 0, ',', '.'));

                header("Location: index.php?page=dashboard&status=selesai&denda=" . $total_denda);
                exit();
            }
        }
    }

    public function tolakPeminjaman() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_peminjaman'];

            $query = "SELECT alat_id FROM peminjaman WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            $alat_id = $res['alat_id'];

            $this->db->begin_transaction();
            try {
                $update = $this->db->prepare("UPDATE peminjaman SET status_pinjam = 'ditolak' WHERE id = ?");
                $update->bind_param("i", $id);
                $update->execute();

                $this->db->query("UPDATE alat SET stok = stok + 1, status = 'tersedia' WHERE id = $alat_id");

                // Tambahkan Log sebelum commit
                $this->simpanLog("Tolak Peminjaman", "Petugas menolak peminjaman ID: $id. Stok alat ID: $alat_id dikembalikan.");

                $this->db->commit();
                header("Location: index.php?page=dashboard&status=ditolak");
            } catch (Exception $e) {
                $this->db->rollback();
                die("Gagal menolak pengajuan: " . $e->getMessage());
            }
        }
    }
}