


<?php
require 'koneksiDB2.php';
require 'createcontroller.php';
require 'createcontroller2.php';
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
    if (isset($_POST['resi1'])&&isset($_POST['status1'])&&isset($_POST['layanan1']))
    {
        $resi=htmlspecialchars($_POST['resi1']);
        $status=htmlspecialchars($_POST['status1']);
        $layanan=htmlspecialchars($_POST['layanan1']);
    
        $resi=mysqli_real_escape_string($conn2,$resi);
        $status=mysqli_real_escape_string($conn2,$status);
        $layanan=mysqli_real_escape_string($conn2,$layanan);
    
        if (empty($resi) || empty($status) || empty($layanan)) {
            die("Semua field harus diisi.");
        }

        else{
            echo "Data berhasil disimpan!";
    
        }
        $stmt = $conn2->prepare("INSERT INTO ");



    }
    
} else {
    die("Metode tidak diizinkan.");
}

$conn2->close();
?>
