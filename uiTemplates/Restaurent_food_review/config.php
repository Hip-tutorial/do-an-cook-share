
<?php
$conn = new mysqli("localhost","root","","food_review");
if($conn->connect_error){
    die("Kết nối database thất bại");
}
session_start();
?>
