
<?php
include 'config.php';

$error = "";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = md5($_POST['password']);

$result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

if($result->num_rows > 0){

$_SESSION['user'] = $result->fetch_assoc();

header("Location:index.php");

}else{

$error = "Sai tài khoản hoặc mật khẩu";

}
}

include 'partials/header.php';
?>

<div class="form-container">

<h2>Đăng nhập</h2>

<p><?= $error ?></p>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Mật khẩu" required>

<button class="btn" name="login">
Đăng nhập
</button>

</form>

</div>

<?php include 'partials/footer.php'; ?>
