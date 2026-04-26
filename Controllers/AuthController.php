<?php
require_once __DIR__ . '/../Models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function prosesRegister($data) {
        return $this->userModel->register($data['username'], $data['password'], $data['nama_lengkap'], $data['role']);
    }

    public function prosesLogin($username, $password) {
        $user = $this->userModel->login($username, $password);
        if ($user) {
            session_start();
            $_SESSION['id_user']  = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            return $user['role'];
        }
        return false;
    }

    public function login($username, $password) {
        // Logika verifikasi password dan set SESSION role
        // Redirect berdasarkan role:
        // Admin -> dashboard_admin.php
        // Petugas -> dashboard_petugas.php
        // Peminjam -> dashboard_peminjam.php
    }

    public function checkAccess($allowedRoles) {
        session_start();
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
            header("Location: login.php?error=unauthorized");
            exit();
        }
    }
}