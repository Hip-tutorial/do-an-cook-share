
<?php
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$message = "";

if(isset($_POST['submit'])){

    $restaurant_id = $_POST['restaurant_id'];
    $rating = $_POST['rating'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['id'];

    $conn->query("INSERT INTO reviews(user_id,restaurant_id,rating,content,created_at)
    VALUES('$user_id','$restaurant_id','$rating','$content',NOW())");

    $message = "Đăng bài thành công";
}

$restaurants = $conn->query("SELECT * FROM restaurants");

include 'partials/header.php';
?>

<div class="form-container">

<h2>Đăng bài review</h2>

<p><?= $message ?></p>

<form method="POST">

<select name="restaurant_id">

<?php while($r = $restaurants->fetch_assoc()): ?>

<option value="<?= $r['id'] ?>">
<?= $r['name'] ?>
</option>

<?php endwhile; ?>

</select>

<select name="rating">
<option value="5">5 sao</option>
<option value="4">4 sao</option>
<option value="3">3 sao</option>
<option value="2">2 sao</option>
<option value="1">1 sao</option>
</select>

<textarea name="content" placeholder="Nhập review..." required></textarea>

<button class="btn" name="submit">
Đăng bài
</button>

</form>

</div>

<?php include 'partials/footer.php'; ?>
