<?php
session_start();
require __DIR__ . '/connect.php';

// 1. Nếu chưa đăng nhập, báo cáo giỏ hàng = 0 sp, tổng tiền = 0
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['items' => [], 'total' => 0]);
    exit();
}

$user_id = $_SESSION['user_id'];

// 2.  Kết hợp JOIN trong SQL bảng Giỏ hàng và bảng Sản phẩm
// Để lấy ra được số lượng user mua, KÈM THEO tên, ảnh, và giá của sp đó
$sql = "SELECT c.id as cart_id, c.quantity, c.size, c.color, 
               p.name, p.main_image, p.price_current 
        FROM cart_items c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = '$user_id'";

$result = $conn->query($sql);

$items = [];
$total_price = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row; // Nhét từng sp vào mảng
        // Tính tổng tiền: Giá hiện tại * Số lượng
        $total_price += ($row['price_current'] * $row['quantity']);
    }
}

// 3. Trả toàn bộ dữ liệu về dưới định dạng JSON (ngôn ngữ thân thiện với Javascript)
echo json_encode(['items' => $items, 'total' => $total_price]);

$conn->close();
?>