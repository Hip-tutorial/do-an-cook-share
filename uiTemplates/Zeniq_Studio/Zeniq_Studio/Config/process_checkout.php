<?php
session_start();
require __DIR__ . '/connect.php';

// Thiết lập header định dạng JSON để phản hồi dữ liệu 
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để thanh toán!']);
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$method = $_POST['method'];

// 1. Truy xuất toàn bộ dữ liệu giỏ hàng của người dùng hiện tại
$sql_cart = "SELECT c.*, p.price_current FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$user_id'";
$result_cart = $conn->query($sql_cart);

if ($result_cart->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng của bạn đang trống!']);
    exit();
}

// Tính tổng tiền và gom hàng
$total_price = 0;
$items = [];
while($row = $result_cart->fetch_assoc()) {
    $items[] = $row;
    $total_price += ($row['price_current'] * $row['quantity']);
}


// Phần Giao dịch (TRANSACTION)

$conn->begin_transaction();

try {
    // 2. Tạo bản ghi thông tin tổng quan của đơn hàng (bảng orders)
    $sql_order = "INSERT INTO orders (user_id, customer_name, phone, address, payment_method, total_price) 
                  VALUES ('$user_id', '$name', '$phone', '$address', '$method', '$total_price')";
    $conn->query($sql_order);
    
    $order_id = $conn->insert_id; // Sử dụng ID hóa đơn vừa được tạo

    // 3. Cập nhật từng sản phẩm trong đơn hàng (bảng order_details) và trừ số lượng sản phẩm tương ứng trong kho
    foreach ($items as $item) {
        $product_id = $item['product_id'];
        $size = $item['size'];
        $color = $item['color'];
        $quantity = $item['quantity'];
        $price = $item['price_current'];

        // Lưu trữ thông tin sản phẩm vào bảng order_details
        $sql_detail = "INSERT INTO order_details (order_id, product_id, size, color, quantity, price) 
                       VALUES ('$order_id', '$product_id', '$size', '$color', '$quantity', '$price')";
        $conn->query($sql_detail);

        // Trừ đi số lượng sản phẩm tương ứng khi hoàn tất thanh toán
        $sql_stock = "UPDATE products SET stock_count = stock_count - $quantity WHERE id = '$product_id'";
        $conn->query($sql_stock);
    }

    // 4. Clear giỏ hàng sau khi ấn nút thanh toán
    $sql_clear = "DELETE FROM cart_items WHERE user_id = '$user_id'";
    $conn->query($sql_clear);

    // Xác nhận giao dịch -> lưu vào database (Commit)
    $conn->commit();

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    // Hủy giao dịch nếu có lỗi xảy ra (Rollback)
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}

$conn->close();
?>