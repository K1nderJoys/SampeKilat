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

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['nama_pelanggan']) && isset($_POST['alamat_jalan_pelanggan']) && isset($_POST['alamat_kecamatan_pelanggan'])&& isset($_POST['alamat_kota_pelanggan']) && isset($_POST['nomor_telpon']))
    {
        $sql="SELECT id_pelanggan from pelanggan";
        $result=$conn2->query($sql);
        
        $data=[];
        while($row=$result->fetch_assoc())
        {
           $data=$row['id_pelanggan'];
        }
        
        $data;
        $id_pelanggan=(int)substr($data,3,10);
        $id_valid=sprintf("PE-%07d",$id_pelanggan+1);
        
        
         
        
        $nama_pelanggan=$_POST['nama_pelanggan'];
        $alamat_jalan_pelanggan=$_POST['alamat_jalan_pelanggan'];
        $alamat_kecamatan_pelanggan=$_POST['alamat_kecamatan_pelanggan'];
        $alamat_kota_pelanggan=$_POST['alamat_kota_pelanggan'];
        $nomor_telepon=$_POST['nomor_telpon'];
        $sql2="INSERT INTO pelanggan (id_pelanggan,nama_pelanggan, alamat_jalan_pelanggan, alamat_kecamatan_pelanggan, alamat_kota_pelanggan, nomor_telpon) VALUES (?,?,?,?,?,?)";
        $stmt=$conn2->prepare($sql2);
        $stmt->bind_param("ssssss",$id_valid,$nama_pelanggan,$alamat_jalan_pelanggan,$alamat_kecamatan_pelanggan,$alamat_kota_pelanggan,$nomor_telepon);
        $stmt->execute();
        
        if(!$stmt->error)
        {
            echo '<script>
            alert("data berhasil dimasukan");
            window.location.href="../../src/homepageAS/HomePageAdminStaff.php";
            </script>
            ';
            // header("Location:../../src/homepageAS/HomePageAdminStaff.php");
        }
        else{
            exit();
           
        }
            

    }

}

   
  



?>