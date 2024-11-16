<?php
$hostname="127.0.0.1";
$username="root";
$password="";
$database="sampaikilat_operational";
$conn2=new mysqli($hostname,$username,$password,$database);


// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
} else {
    // echo "Connected successfully";
}
?>

