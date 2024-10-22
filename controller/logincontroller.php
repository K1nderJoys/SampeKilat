<?php
include './koneksiDB.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
$username=htmlspecialchars($_POST['username']);
$password=htmlspecialchars($_POST['password']);
$usernamebersih=mysqli_real_escape_string($conn,$username);
$passwordbersih=mysqli_real_escape_string($conn,$password);


$sql="SELECT * FROM testing WHERE username='$usernamebersih' AND pass='$passwordbersih'";
$kueri=$conn->query($sql);
if($kueri->num_rows>0)
{
   header("Location: ../homepage.html");
    
}

}


?>