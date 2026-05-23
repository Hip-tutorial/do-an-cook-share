<?php
require __DIR__ . '/connect.php';

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Cập nhật trạng thái đơn hàng trong database
    $sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
}
$conn->close();
?>