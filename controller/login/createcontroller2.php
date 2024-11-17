


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
    if (isset($_POST['nama_penerima'])&&isset($_POST['no_penerima'])&&isset($_POST['alamat_penerima']) &&isset($_POST['ID_Pelanggan'])&&isset($_POST['no_rumah'])&&isset($_POST['alamat_kota'])&&isset($_POST['alamat_kecamatan'])&&isset($_POST['tanggal_pengiriman'])&&isset($_POST['ID_Servis']))
    {
        $nama_penerima=htmlspecialchars($_POST['nama_penerima']);
        $no_penerima=htmlspecialchars($_POST['no_penerima']);
        $alamat_penerima=htmlspecialchars($_POST['alamat_penerima']);
        $id_pelanggan=htmlspecialchars($_POST['ID_Pelanggan']);
        $no_rumah=htmlspecialchars($_POST['no_rumah']);
        $alamat_kota=htmlspecialchars($_POST['alamat_kota']);
        $alamat_kecamatan=htmlspecialchars($_POST['alamat_kecamatan']);
        $tanggal_pengiriman=htmlspecialchars($_POST['tanggal_pengiriman']);
        $id_servis=htmlspecialchars($_POST['ID_Servis']);

        $nama_penerima=mysqli_real_escape_string($conn2,$nama_penerima);
        $no_penerima=mysqli_real_escape_string($conn2,$no_penerima);
        $alamat_penerima=mysqli_real_escape_string($conn2,$alamat_penerima);
        $id_pelanggan=mysqli_real_escape_string($conn2 , $id_pelanggan);
        $no_rumah=mysqli_real_escape_string($conn2, $no_rumah);
        $alamat_kota=mysqli_real_escape_string($conn2, $alamat_kota);
        $alamat_kecamatan=mysqli_real_escape_string($conn2, $alamat_kecamatan);
        $tanggal_pengiriman=mysqli_real_escape_string($conn2, $tanggal_pengiriman);
        $id_servis=mysqli_real_escape_string($conn2, $id_servis);
    
        if (empty($nama_penerima) || empty($no_penerima) || empty($alamat_penerima) || empty($id_pelanggan) || empty($no_rumah) || empty($alamat_kota) || empty($alamat_kecamatan) || empty($tanggal_pengiriman) || empty($id_servis)) {
            die("Semua field harus diisi.");
        }
        else{

            echo "Data berhasil disimpan!";
            $kueri="SELECT nomor_resi from resi";
            $result=$conn2->query($kueri);
            $data=[];
            while($row2=$result->fetch_assoc())
            {
                $data=$row2['nomor_resi'];
            }
            $data;
            $id_nomor_resi=(int)substr($data,3,10);
            $id_valid=sprintf("RS-%07d",$id_nomor_resi+1);

            echo $id_valid;



$kueri3="INSERT into resi (nomor_resi,id_pelanggan,nama_penerima,alamat_jalan_penerima,nomor_rumah_penerima,alamat_kota_penerima, alamat_kecamatan_penerima,nomor_telpon_penerima,tanggal_permintaan_pengiriman,id_servis)values (?,?,?,?,?,?,?,?,?,?);";
$stmt=$conn2->prepare($kueri3);
$stmt->bind_param("ssssssssss",$id_valid,$id_pelanggan, $nama_penerima, $alamat_penerima, $no_rumah, $alamat_kota, $alamat_kecamatan, $no_penerima, $tanggal_pengiriman,$id_servis);
$stmt->execute();

            header("Location:../../src/homepageAS/HomePageAdminStaff.php");
    
        }

    }
    
} else {
    die("Metode tidak diizinkan.");
}

$conn2->close();
?>
