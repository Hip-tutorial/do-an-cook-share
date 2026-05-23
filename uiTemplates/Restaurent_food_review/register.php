
<?php
include 'config.php';

$msg = "";

if(isset($_POST['register'])){

$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']);

$conn->query("INSERT INTO users(username,email,password,role)
VALUES('$username','$email','$password','user')");

$msg = "Đăng ký thành công";
}

include 'partials/header.php';
?>

<div class="form-container">

<h2>Đăng ký</h2>

<p><?= $msg ?></p>

<form method="POST">

<input type="text" name="username" placeholder="Tên người dùng" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Mật khẩu" required>

<button class="btn" name="register">
Đăng ký
</button>

</form>

</div>

<?php include 'partials/footer.php'; ?>
