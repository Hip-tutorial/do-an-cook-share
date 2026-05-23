<?php
session_start();
// Gọi file kết nối Database nằm ngay cạnh nó
require __DIR__ . '/connect.php'; 

// 1. Kiểm tra user đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Lấy ID của user đã đăng nhập
    
    // 2. Lấy thông tin sản phẩm do JS gửi lên
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    // Nếu không gửi số lượng lên, mặc định là 1
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; 

    // 3. Kiểm tra xem sản phẩm này đã có trong cart chưa
    $check_sql = "SELECT * FROM cart_items WHERE user_id = '$user_id' AND product_id = '$product_id' AND size = '$size' AND color = '$color'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // TRƯỜNG HỢP A: Đã có món này rồi -> Cập nhật cộng dồn số lượng (VD: mua 1 sp, nếu đã có 1 sp trong giỏ hàng, +1 = 2 sp)
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        
        $update_sql = "UPDATE cart_items SET quantity = '$new_quantity' WHERE id = " . $row['id'];
        
        if ($conn->query($update_sql) === TRUE) {
            echo "success";
        } else {
            echo "Lỗi cập nhật: " . $conn->error;
        }
    } else {
        // TRƯỜNG HỢP B: Chưa có món này -> Thêm dòng mới vào giỏ hàng
        $insert_sql = "INSERT INTO cart_items (user_id, product_id, size, color, quantity) VALUES ('$user_id', '$product_id', '$size', '$color', '$quantity')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "success";
        } else {
            echo "Lỗi thêm mới: " . $conn->error;
        }
    }
}
$conn->close();
?>