<?php
session_start();
require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Tìm người dùng theo email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 2. Kiểm tra mật khẩu đã mã hóa
        if (password_verify($password, $user['password'])) {
            // Đăng nhập đúng: Lưu thông tin vào SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            
            echo "success|" . $user['fullname']; // Trả về thông báo kèm tên cho JS
        } else {
            echo "Mật khẩu không chính xác!";
        }
    } else {
        echo "Email không tồn tại!";
    }
}
$conn->close();
?>