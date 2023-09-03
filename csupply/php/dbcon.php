<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "csdb1";
$port = 3307;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db, $port);
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>