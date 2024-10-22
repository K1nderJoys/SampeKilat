<?php
session_start(); 

include './koneksiDB.php'; 

// Memeriksa apakah user mengirimkan form via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    
    // Membersihkan input untuk mencegah SQL Injection
    $usernamebersih = mysqli_real_escape_string($conn, $username);
    $passwordbersih = mysqli_real_escape_string($conn, $password);

    // Query untuk memeriksa apakah username dan password ada di database
    $sql = "SELECT * FROM testing WHERE username='$usernamebersih' AND pass='$passwordbersih'";
    $kueri = $conn->query($sql);

    // Jika hasil query lebih dari 0 baris, login berhasil
    if ($kueri->num_rows > 0) {
        $row = $kueri->fetch_assoc(); // Mengambil data user dari hasil query

        // Menyimpan data penting ke dalam session
        $_SESSION['username'] = $row['username']; // Simpan username ke session
        $_SESSION['session_id'] = session_id(); // Simpan session ID
        
        // Redirect ke halaman utama setelah login
        header("Location: ../homepage.html");
        exit(); // Menghentikan script setelah redirect

    } else {
        // Jika username atau password salah
        echo "Username atau password salah!";
    }

} else {
    // Jika session belum ada, buat session id baru untuk user
    if (!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = session_id();
    }
}

