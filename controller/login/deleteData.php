<?php
session_start();
require 'koneksiDB2.php'; // Koneksi ke database

if ($_SESSION['role'] !== 'RL-001') {
    die("<script>
            alert('Anda tidak memiliki akses untuk menghapus data.');
            window.location.href='../../src/homepageAS/HomePageAdminStaff.php';
         </script>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomor_resi'])) {
    $nomor_resi = $_POST['nomor_resi'];

    $stmt = $conn2->prepare("DELETE FROM transit WHERE nomor_resi = ?");
    $stmt->bind_param("s", $nomor_resi);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "<script>
                alert('Data dengan Nomor Resi $nomor_resi berhasil dihapus.');
                window.location.href='../../src/homepageAS/HomePageAdminStaff.php';
              </script>";
    } else {
        echo "<script>
                alert('Nomor Resi tidak ditemukan atau gagal dihapus.');
                window.location.href='../../src/homepageAS/HomePageAdminStaff.php';
              </script>";
    }
    $stmt->close();
} else {
    echo "<script>
            alert('Akses tidak valid.');
            window.location.href='../../src/homepageAS/HomePageAdminStaff.php';
          </script>";
}
?>
