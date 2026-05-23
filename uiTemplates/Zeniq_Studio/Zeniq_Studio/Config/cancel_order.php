<?php
session_start();
require __DIR__ . '/connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ!']);
    exit();
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];

// 1. Kiểm tra sản phẩm có phải trong trạng thái 'Chờ xử lý' không
$sql_check = "SELECT status FROM orders WHERE id = '$order_id' AND user_id = '$user_id'";
$res_check = $conn->query($sql_check);
$order = $res_check->fetch_assoc();

if (!$order || $order['status'] !== 'Chờ xử lý') {
    echo json_encode(['status' => 'error', 'message' => 'Không thể hủy đơn hàng này!']);
    exit();
}

// Quá trình hủy đơn

$conn->begin_transaction();
    
try {
    // 2. Cập nhật trạng thái đơn hàng thành 'Đã hủy'
    $conn->query("UPDATE orders SET status = 'Đã hủy' WHERE id = '$order_id'");

    // 3. Lấy danh sách món hàng trong đơn này để HOÀN LẠI KHO
    $sql_items = "SELECT product_id, quantity FROM order_details WHERE order_id = '$order_id'";
    $res_items = $conn->query($sql_items);

    while ($item = $res_items->fetch_assoc()) {
        $p_id = $item['product_id'];
        $qty = $item['quantity'];
        // Lệnh CỘNG TRẢ LẠI KHO
        $conn->query("UPDATE products SET stock_count = stock_count + $qty WHERE id = '$p_id'");
    }

    // XÁC NHẬN GIAO DỊCH 
    $conn->commit();
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    // HỦY GIAO DỊCH (ROLLBACK)
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
}

$conn->close();
?>