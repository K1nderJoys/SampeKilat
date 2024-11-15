<?php
require '../../controller/login/logincontroller.php';
$username=$_SESSION['username'];


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
      <p class="username"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
    </div>
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
        <tr>
          <td>1</td>
          <td>RESI NUMBER</td>
          <td>Pengiriman</td>
          <td>Tejo</td>
          <td>UserName</td>
        </tr>
      </tbody>
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
