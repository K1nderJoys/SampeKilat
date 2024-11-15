


<?php
require 'koneksiDB2.php';
require 'createcontroller.php';
require 'logincontroller.php';

if (!isset($_SESSION['csrf_token']) || !isset($_COOKIE['csrf_token'])) {
    die("Akses ditolak: Token CSRF tidak ditemukan.");
}

if ($_SESSION['csrf_token'] !== $_COOKIE['csrf_token']) {
    die("Akses ditolak: Token CSRF tidak valid.");
}

// Memvalidasi apakah pengguna telah login
if (!isset($_SESSION['username']) || !isset($_SESSION['session_id']) || $_SESSION['session_id'] !== session_id()) {
    die("Akses ditolak: Anda belum login.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nama_penerima'])&&isset($_POST['no_penerima'])&&isset($_POST['alamat_penerima']))
    {
        $nama_penerima=htmlspecialchars($_POST['nama_penerima']);
        $no_penerima=htmlspecialchars($_POST['no_penerima']);
        $alamat_penerima=htmlspecialchars($_POST['alamat_penerima']);
    
        $nama_penerima=mysqli_real_escape_string($conn2,$nama_penerima);
        $no_penerima=mysqli_real_escape_string($conn2,$no_penerima);
        $alamat_penerima=mysqli_real_escape_string($conn2,$alamat_penerima);
    
        if (empty($nama_penerima) || empty($no_penerima) || empty($alamat_penerima)) {
            die("Semua field harus diisi.");
        }
        else{
            echo "Data berhasil disimpan!";
            header("Location:../../src/createDelivery/Create3.php");
    
        }

    }
    
} else {
    die("Metode tidak diizinkan.");
}

$conn2->close();
?>
