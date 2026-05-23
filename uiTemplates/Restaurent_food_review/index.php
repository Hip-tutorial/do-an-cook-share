
<?php
include 'config.php';
$restaurants = $conn->query("SELECT * FROM restaurants ORDER BY id DESC");
include 'partials/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Food Review Việt Nam</h1>
        <p>Khám phá, đánh giá và chia sẻ trải nghiệm ăn uống</p>

        <?php if(isset($_SESSION['user'])): ?>
            <a class="hero-btn" href="create_post.php">+ Đăng bài review</a>
        <?php endif; ?>
    </div>
</section>

<div class="container">

<h2 class="section-title">Nhà hàng nổi bật</h2>

<div class="grid">

<?php while($r = $restaurants->fetch_assoc()): ?>

<div class="card">
    <img src="<?= $r['image'] ?>">

    <div class="card-body">
        <h3><?= $r['name'] ?></h3>

        <p class="location"><?= $r['address'] ?></p>

        <div class="rating">
            ⭐ <?= $r['rating'] ?>/5
        </div>

        <p class="desc">
            <?= $r['description'] ?>
        </p>

        <a class="btn" href="restaurant.php?id=<?= $r['id'] ?>">
            Xem chi tiết
        </a>
    </div>
</div>

<?php endwhile; ?>

</div>
</div>

<?php include 'partials/footer.php'; ?>
