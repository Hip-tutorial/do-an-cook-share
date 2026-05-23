<?php
session_start();
// câu lệnh DIR giúp xác định đường dẫn đến file connect.php chính xác
require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Kiểm tra xem email đã tồn tại chưa
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "Email này đã được sử dụng!";
    } else {
        // 2. Mã hóa mật khẩu để bảo mật trước khi lưu vào database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. Lưu vào database
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Đăng ký thành công! Hãy đăng nhập.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}
$conn->close();
?>