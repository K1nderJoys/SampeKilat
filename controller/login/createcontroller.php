
<?php
require 'koneksiDB2.php';
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

// Proses data yang dikirim melalui form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_pengirim'])&&isset($_POST['nama_pengirim'])&&isset($_POST['nomor_telepon'])&&isset($_POST['alamat_pengirim']))
    {
    $id_pengirim = htmlspecialchars($_POST['id_pengirim']);
    $nama_pengirim = htmlspecialchars($_POST['nama_pengirim']);
    $nomor_telepon = htmlspecialchars($_POST['nomor_telepon']);
    $alamat_pengirim = htmlspecialchars($_POST['alamat_pengirim']);

    $id_pengirim = mysqli_real_escape_string($conn2,$id_pengirim);
    $nama_pengirim = mysqli_real_escape_string($conn2,$nama_pengirim);
    $nomor_telepon = mysqli_real_escape_string($conn2,$nomor_telepon); 
    $alamat_pengirim = mysqli_real_escape_string($conn2,$alamat_pengirim);
    

    // Validasi data
    if (empty($id_pengirim) || empty($nama_pengirim) || empty($nomor_telepon) || empty($alamat_pengirim)) {
        die("Semua field harus diisi.");
    }
    else{
        echo "Data berhasil disimpan!";
        header("Location:../../src/createDelivery/Create2.php");

    }
   

    }
    

    
} else {
    die("Metode tidak diizinkan.");
}


?>
