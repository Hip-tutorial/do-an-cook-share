
<?php
include 'config.php';

$id = $_GET['id'];

$restaurant = $conn->query("SELECT * FROM restaurants WHERE id=$id")->fetch_assoc();

$reviews = $conn->query("
SELECT reviews.*, users.username
FROM reviews
JOIN users ON reviews.user_id = users.id
WHERE restaurant_id=$id
ORDER BY reviews.id DESC
");

include 'partials/header.php';
?>

<div class="container">

<div class="restaurant-detail">

<img src="<?= $restaurant['image'] ?>">

<div>
<h1><?= $restaurant['name'] ?></h1>

<p><b>Địa chỉ:</b> <?= $restaurant['address'] ?></p>

<p><?= $restaurant['description'] ?></p>

<div class="rating-box">
⭐ <?= $restaurant['rating'] ?>/5
</div>
</div>

</div>

<h2 class="section-title">Review từ người dùng</h2>

<?php while($review = $reviews->fetch_assoc()): ?>

<div class="review-box">
<h3><?= $review['username'] ?></h3>

<div class="rating">
⭐ <?= $review['rating'] ?>/5
</div>

<p><?= $review['content'] ?></p>
</div>

<?php endwhile; ?>

</div>

<?php include 'partials/footer.php'; ?>
