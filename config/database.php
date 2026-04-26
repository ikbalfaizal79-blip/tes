<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "peminjaman_alat";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        } catch(Exception $e) {
            echo "Koneksi Error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>