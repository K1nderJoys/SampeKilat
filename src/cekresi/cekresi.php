<?php
require '../../controller/login/koneksiDB2.php'; // Pastikan file ini berisi koneksi ke database

// Pastikan nomor resi dikirim melalui metode POST atau GET
if (isset($_POST['nomor_resi'])) {
    $nomor_resi = $_POST['nomor_resi']; // Input nomor resi

    // Query dengan Prepared Statement
    $query = "
        SELECT Distinct r.nomor_resi, 
               p.nama_pelanggan, 
               r.nama_penerima,

               CONCAT('Jl. ', alamat_jalan_penerima, ', ', nomor_rumah_penerima, ', ', alamat_kecamatan_penerima, ', ', alamat_kota_penerima) AS alamat_lengkap, 
               t.tanggal_jam_pengiriman, 
               pp.posisi_terakhir 
        FROM resi r 
        JOIN pelanggan p ON p.id_pelanggan = r.id_pelanggan 
        JOIN transit t ON r.nomor_resi = t.nomor_resi 
        JOIN posisi_paket pp ON t.id_posisi_terakhir_paket = pp.id_posisi_terakhir_paket 
        WHERE r.nomor_resi = ? 
        ORDER BY t.tanggal_jam_pengiriman DESC
    ";

    // Siapkan Prepared Statement
    $stmt = $conn2->prepare($query);
    if (!$stmt) {
        die("Kesalahan dalam persiapan statement: " . $conn->error);
    }

    // Bind parameter (string untuk nomor resi)
    $stmt->bind_param("s", $nomor_resi);

    // Eksekusi query
    $stmt->execute();

    $row=null;
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $trackingData[] = [
                'status_date' => $row['tanggal_jam_pengiriman'],
                'status_description' => $row['posisi_terakhir'],
               
            ];
        }
        $result->data_seek(0);
        
        $row=$result->fetch_assoc();
       
        
    } else {
        echo "Tidak ada data ditemukan untuk nomor resi tersebut.";
    }
   

    // Tutup statement

} 
else {
    echo "Nomor resi tidak diberikan.";
}

// Tutup koneksi

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Resi</title>
    <link rel="stylesheet" href="../../css/cekresi/cekresi.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../../assets/homepage/image/png-clipart-lightning-black-and-white-lightning-angle-white-removebg-preview.png" alt="Logo">
            <span>SampaiKilat</span>
        </div>
        <nav>
            <a href="#home">Home</a>
            <a href="#cek-resi">Cek Resi</a>
            <a href="#about">About Us</a>
            <a href="#help">Help</a>
        </nav>
    </header>

    <!-- Main Container -->
     
    <div class="container">
        <h1>Cek Resi</h1>
        <div class="nav-buttons">
            <button class="btn-gray"><b>Cek Resi</b></button>
            <button><b>Cek Tarif</b></button>
            <button><b>Cek Lokasi</b></button>
        </div>
        <div class="input-section">
            <label for="resi-number"><b>Masukkan Nomor Resi</b></label>
            <form action="cekresi.php" method="post"> <input type="text" id="resi-number" name="nomor_resi"  placeholder="Lacak hingga 20 nomor resi">
        
        </form>
           
            <small>Jika lebih dari satu resi, gunakan koma</small>
        </div>
        <div>
            <button class="track-btn"><b>Lacak Resi</b></button>
        </div>
    </div>

    <!-- Modal for Tracking Details -->
    <div id="trackingModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&larr; Back</span>
            <div class="resi-info">
                <p>Nomor Resi : <span><?php echo $row['nomor_resi'];?></span></p>
                <p>Nama Pengirim : <span><?php echo $row['nama_pelanggan'];?></span></span></p>
                <p>Nama Penerima : <span><?php echo $row['nama_penerima'];?></span></p>
                <p>Alamat Penerima : <span><?php echo $row['alamat_lengkap'];?></span></p>
            </div>
            <hr>
            <div class="tracking-status">
    <?php foreach ($trackingData as $trackingItem): ?>
        <div class="status-item">
            <div class="status-date">
                <?php echo htmlspecialchars($trackingItem['status_date']); ?>
            </div>
            <div class="status-info">
                <div class="status-icon"></div>
                <p><?php echo htmlspecialchars($trackingItem['status_description']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <div class="footer-logo-container">
                    <img src="../../assets/homepage/image/png-clipart-lightning-black-and-white-lightning-angle-white-removebg-preview.png" alt="Logo" class="footer-logo">
                    <p><b>SampaiKilat</b></p>
                </div>
                <p>CUSTOMER SERVICE</p>
                <p><img src="../../assets/homepage/image/684846.png" alt=""> (021) 222 2222</p>
                <p><img src="../../assets/homepage/image/png-transparent-computer-icons-envelope-mail-envelope-miscellaneous-angle-triangle-removebg-preview (1).png" alt=""> sampai@kilat.co.id</p>
                <div class="social-media">
                    <img src="../../assets/homepage/image/Twitter-new-cross-mark-Icon-PNG-X-removebg-preview.png" alt="Facebook">
                    <img src="../../assets/homepage/image/59439.png" alt="Instagram">
                    <img src="../../assets/homepage/image/images-removebg-preview.png" alt="Twitter">
                    <img src="../../assets/homepage/image/png-transparent-instagram-vector-brand-logos-icon-removebg-preview.png" alt="Instagram">
                </div>
            </div>
            <div class="footer-section">
                <p><b>PERUSAHAAN</b></p>
                <p>Profil Perusahaan</p>
                <p>Bantuan</p>
            </div>
            <div class="footer-section">
                <p><b>LAYANAN</b></p>
                <p>Lacak Pengiriman</p>
                <p>Cek Tarif</p>
                <p>Lokasi</p>
            </div>
            <div class="footer-section">
                <p><b>Peraturan</b></p>
                <p>Larangan Pengiriman</p>
            </div>
        </div>
    </footer>

    <script>
        // Get the modal element
        const modal = document.getElementById("trackingModal");
    
        // Get the "Cek Resi" button
        const trackButton = document.querySelector(".track-btn");
    
        // Get the close button inside the modal
        const closeBtn = document.querySelector(".close-btn");
    
        // Show the modal when the "Cek Resi" button is clicked
        trackButton.onclick = function () {
            modal.style.display = "block";
        };
    
        // Hide the modal when the close button is clicked
        closeBtn.onclick = function () {
            modal.style.display = "none";
        };
    
        // Hide the modal when clicking outside the modal content
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
    
</body>
</html>
