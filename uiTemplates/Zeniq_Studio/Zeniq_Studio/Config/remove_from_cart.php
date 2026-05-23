<?php
session_start();
require __DIR__ . '/connect.php';

if (isset($_POST['cart_id']) && isset($_SESSION['user_id'])) {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Chỉ xóa nếu món đồ đó đúng là của người đang đăng nhập
    $sql = "DELETE FROM cart_items WHERE id = '$cart_id' AND user_id = '$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}
$conn->close();
?>