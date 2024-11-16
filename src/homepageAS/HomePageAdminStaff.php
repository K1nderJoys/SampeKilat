<?php
session_start();
require '../../controller/login/koneksiDB2.php'; // Koneksi database

// Ambil role dari session
$role_id = $_SESSION['role'] ?? null; // Gunakan null jika session role tidak ada

// Validasi apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['session_id']) || $_SESSION['session_id'] !== session_id()) {
    die("Akses ditolak: Anda belum login.");
}

// Query untuk mengambil data dari database
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

$data = [];
if ($result->num_rows > 0) {
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'Count' => $count,
            'No_Resi' => $row['nomor_resi'],
            'Status' => $row['id_posisi_terakhir_paket'],
            'Kurir' => $row['plat_nomor_kendaraan'],
            'Staff' => $row['nomor_resi'],
        ];
        $count++;
    }
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
      <tbody>
        <?php foreach ($data as $datas): ?>
        <tr>
          <td><?php echo $datas['Count']; ?></td>
          <td><?php echo $datas['No_Resi']; ?></td>
          <td><?php echo $datas['Status']; ?></td>
          <td><?php echo $datas['Kurir']; ?></td>
          <td><?php echo $datas['Staff']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="buttons">
      <button class="create" onclick="window.location.href='../createDelivery/Create1.php'">Create</button>
      <button class="update" onclick="window.location.href='../updatingDelivery/Update1.html'">Update</button>
      <?php if ($role_id === 'RL-001'): // Tampilkan tombol Delete hanya untuk Admin ?>
        <button class="delete" onclick="showDeletePopup()">Delete</button>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($role_id === 'RL-001'): // Tampilkan popup hanya untuk Admin ?>
  <div class="popup-container" id="deletePopup">
    <div class="popup-content">
      <form method="POST" action="../../controller/login/deleteData.php">
        <p>Masukkan Nomor Resi yang ingin dihapus:</p>
        <input type="text" name="nomor_resi" placeholder="Masukkan Nomor Resi" required>
        <div class="popup-buttons">
          <button type="submit" class="popup-delete">Delete</button>
          <button type="button" class="popup-cancel" onclick="closePopup()">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <script>
    function showDeletePopup() {
      document.getElementById("deletePopup").style.visibility = "visible";
      document.getElementById("deletePopup").style.opacity = "1";
    }

    function closePopup() {
      document.getElementById("deletePopup").style.visibility = "hidden";
      document.getElementById("deletePopup").style.opacity = "0";
    }
  </script>
</body>
</html>
