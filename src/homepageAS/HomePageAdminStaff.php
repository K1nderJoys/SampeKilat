<?php
require '../../controller/login/koneksiDB2.php';
require '../../controller/login/logincontroller.php';
$username=$_SESSION['username'];
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
$sql = "
    SELECT 
        transit.nomor_resi,
        isi_paket.desk_isi_paket AS id_isi_paket,
        supir.nama_supir AS plat_nomor_kendaraan,
        transit.tanggal_jam_pengiriman,
        posisi_paket.posisi_terakhir AS id_posisi_terakhir_paket
    FROM 
        transit
    JOIN 
        isi_paket ON transit.id_isi_paket = isi_paket.id_isi_paket
    JOIN 
        supir ON transit.plat_nomor_kendaraan = supir.plat_nomor_kendaraan
    JOIN 
        posisi_paket ON transit.id_posisi_terakhir_paket = posisi_paket.id_posisi_terakhir_paket
    ORDER BY 
        transit.tanggal_jam_pengiriman DESC
";
$result = $conn2->query($sql);
if ($result->num_rows > 0) {
    // Tampilkan setiap baris data sebagai elemen HTML <tr>
    $count=1;
    while ($row = $result->fetch_assoc()) {
        $data[]=[
          'Count'=>$count,
          'No_Resi' => $row['nomor_resi'],
          'Status'=> $row['id_posisi_terakhir_paket'],
          'Kurir'=>$row['plat_nomor_kendaraan'],
          'Staff'=>$row['nomor_resi'],

        ];
        $count+=1;

    }
} else {
    echo "<tr><td colspan='5'>No data available</td></tr>";
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengiriman</title>
  <link rel="stylesheet" href="../../css/homepageAS/HomePageAdminStaff.css">
</head>
<body>
  <div class="sidebar">
    <div class="profile">
      <div class="profile-picture"><img src="../../assets/homepagestaff/image/UserIcon.png" alt=""></div>
      <p class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
    </div>
    
    <ul class="menu">
      <li><a href="#dashboard">Dashboard</a></li>
      <li><a href="#mendaftarkanPelanggan">Mendaftarkan Pelanggan</a></li>
    </ul>
  
    <button class="logout-button">
      <img src="../../assets/homepagestaff/image/logout-512.jpg" alt="">
      <span>LogOut</span>
    </button>
  </div>
  
  <div class="content">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>No Resi</th>
          <th>Status</th>
          <th>Kurir</th>
          <th>Staff</th>
        </tr>
      </thead>
      <?php foreach($data as $datas):?>
      <tbody>
        <tr>
          <td><?php echo $datas['Count']?></td>
          <td><?php echo $datas['No_Resi']?></td>
          <td><?php echo $datas['Status']?></td>
          <td><?php echo $datas['Kurir']?></td>
          <td><?php echo $datas['Staff']?></td>
        </tr>
      </tbody>
      <?php endforeach;?>
    </table>
    <div class="buttons">
      <!-- Tombol Create langsung mengarah ke Create1.html -->
      <button class="create" onclick="window.location.href='../createDelivery/Create1.php'">Create</button>
      <button class="update" onclick="window.location.href='../updatingDelivery/Update1.html'">Update</button>
      <button class="delete" onclick="showDeletePopup()">Delete</button>
    </div>
  </div>

  <!-- Popup Delete Confirmation -->
  <div class="popup-container" id="deletePopup">
    <div class="popup-content">
      <p>Apakah Anda yakin ingin menghapus data pengiriman? Tindakan ini tidak dapat dibatalkan.</p>
      <div class="popup-buttons">
        <button class="popup-delete" onclick="confirmDelete()">Delete</button>
        <button class="popup-cancel" onclick="closePopup()">Cancel</button>
      </div>
    </div>
  </div>

  <script>
    function showDeletePopup() {
      document.getElementById("deletePopup").style.visibility = "visible";
      document.getElementById("deletePopup").style.opacity = "1";
    }

    function closePopup() {
      document.getElementById("deletePopup").style.visibility = "hidden";
      document.getElementById("deletePopup").style.opacity = "0";
    }

    function confirmDelete() {
      alert("Data pengiriman berhasil dihapus.");
      closePopup();
    }
  </script>
</body>
</html>
