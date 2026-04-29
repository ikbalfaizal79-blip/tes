<?php
// File: index.php
session_start();

require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PeminjamController.php';

$database = new Database();
$db = $database->getConnection();

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    
    // --- AUTHENTICATION ---
    case 'login':
        if (isset($_SESSION['role'])) header("Location: index.php?page=dashboard");
        include 'views/auth/login.php';
        break;

    case 'proses-login':
        $auth = new AuthController($db);
        $auth->auth();
        break;

    case 'proses-register':
        $auth = new AuthController($db);
        $auth->register();
        break;

    case 'logout':
        $auth = new AuthController($db);
        $auth->logout();
        break;


    // --- DASHBOARD (DYNAMICS BY ROLE) ---
    case 'dashboard':
        if (!isset($_SESSION['role'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SESSION['role'] === 'admin') {
            include 'views/admin/dashboard.php';
        } 
        elseif ($_SESSION['role'] === 'petugas') {
            include 'views/petugas/dashboard.php';
        } 
        elseif ($_SESSION['role'] === 'peminjam') {
            $peminjam = new PeminjamController($db);
            $peminjam->index();
        }
        break;


    // --- MENU PETUGAS ---
    case 'persetujuan':
        if ($_SESSION['role'] !== 'petugas' && $_SESSION['role'] !== 'admin') die("Akses Ditolak");
        echo "<h1>Halaman Persetujuan Peminjaman</h1><a href='index.php?page=dashboard'>Kembali</a>";
        break;

    case 'pantau-pengembalian':
        if ($_SESSION['role'] !== 'petugas' && $_SESSION['role'] !== 'admin') die("Akses Ditolak");
        echo "<h1>Monitoring Pengembalian Alat</h1><a href='index.php?page=dashboard'>Kembali</a>";
        break;


    // --- MENU ADMIN (CRUD) ---
    case 'crud-user':
        if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
        echo "<h1>Halaman Kelola User</h1> include 'views/admin/dashboard.php';<a href='index.php?page=dashboard'>Kembali</a>";
        break;

    case 'crud-alat':
        if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
        echo "<h1>Halaman Kelola Alat</h1><a href='index.php?page=dashboard'>Kembali</a>";
        break;


  // ... di dalam switch ($page) ...
case 'ajukan-pinjam':
    if ($_SESSION['role'] !== 'peminjam') die("Akses Ditolak");
    $peminjam = new PeminjamController($db);
    $peminjam->formAjukan();
    break;

case 'proses-ajukan':
    if ($_SESSION['role'] !== 'peminjam') die("Akses Ditolak");
    $peminjam = new PeminjamController($db);
    $peminjam->simpanPengajuan();
    break;

    default:
        echo "<center><h3>404 - Halaman Tidak Ditemukan</h3><a href='index.php'>Kembali ke Dashboard</a></center>";
        break;

      case 'acc-peminjaman':
    if ($_SESSION['role'] !== 'petugas' && $_SESSION['role'] !== 'admin') {
        die("Akses Ditolak");
    }
    require_once 'controllers/PetugasController.php';
    $petugas = new PetugasController($db);
    $petugas->accPeminjaman(); 
    break;
    
    case 'proses-kembali':
    if ($_SESSION['role'] === 'peminjam') die("Akses Ditolak");
    require_once 'controllers/PetugasController.php';
    $petugas = new PetugasController($db);
    $petugas->prosesKembali();
    break;

    case 'tolak-peminjaman':
    if ($_SESSION['role'] !== 'petugas' && $_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/PetugasController.php';
    $petugas = new PetugasController($db);
    $petugas->tolakPeminjaman();
    break;

    case 'kelola-user':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->indexUser();
    break;

    case 'simpan-user':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->simpanUser();
    break;

   case 'update-user':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->updateUser();
    break;

case 'hapus-user':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->hapusUser();
    break;

   case 'kelola-alat':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php'; // Pastikan file controller dimuat
    $admin = new AdminController($db); // Inisialisasi variabel $admin dengan koneksi database
    $admin->indexAlat();
    break;

case 'simpan-alat':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->simpanAlat();
    break;

case 'update-alat':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php'; //
    $admin = new AdminController($db); //
    $admin->updateAlat();
    break;

case 'hapus-alat':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->hapusAlat();
    break;

    case 'log-aktivitas':
    if ($_SESSION['role'] !== 'admin') die("Akses Ditolak");
    require_once 'controllers/AdminController.php';
    $admin = new AdminController($db);
    $admin->indexLog();
    break;
    
}
