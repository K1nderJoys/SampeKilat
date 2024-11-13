<?php
session_start(); 

include './koneksiDB.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    
    $usernamebersih = mysqli_real_escape_string($conn, $username);
    $passwordbersih = mysqli_real_escape_string($conn, $password);
    $salt="SampaiKilat";
    $passwordbersih=md5(md5(md5($passwordbersih).$salt));
    echo $passwordbersih;


   
    $stmt = $conn->prepare("SELECT * FROM testing WHERE username = ? AND pass = ?");
    $stmt->bind_param("ss",$usernamebersih,$passwordbersih);
    $stmt->execute();
    $result=$stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Mengambil data user dari hasil query

        // Menyimpan data penting ke dalam session
        $_SESSION['username'] = $row['username']; // Simpan username ke session
        $_SESSION['session_id'] = session_id(); // Simpan session 
        
       
        header("Location: ../homepage.html");
        exit(); 
    } else {
        
        header("Location:../src/login_admin/loginpage");
        exit();
       
        
       
    }

} else {
    // Jika session belum ada, buat session id baru untuk user
    if (!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = session_id();
    }
}

