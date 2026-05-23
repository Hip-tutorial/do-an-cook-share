<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/recipes.php';

$pageTitle = 'Trang chủ';
$keyword = trim($_GET['q'] ?? '');

$db = getDB();
$recipes = fetchRecipes($db, $keyword);

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container hero-inner">
        <div class="hero-content">
            <span class="eyebrow">CookShare Việt Nam</span>
            <h1>Chia sẻ hương vị gia đình, khám phá món ngon mỗi ngày</h1>
            <p>Không gian để bạn lưu lại công thức yêu thích, học cách nấu từ cộng đồng và góp ý cho từng món ăn.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= baseUrl('pages/recipes.php') ?>">Khám phá công thức</a>
                <a class="btn btn-light" href="<?= baseUrl('pages/add-recipe.php') ?>">Chia sẻ món ngon</a>
            </div>
        </div>
        <div class="hero-stats" aria-label="Thông tin nổi bật">
            <div>
                <strong><?= count($recipes) ?></strong>
                <span>Công thức hiện có</span>
            </div>
            <div>
                <strong>2</strong>
                <span>Tài khoản demo</span>
            </div>
            <div>
                <strong>10</strong>
                <span>Món seed mẫu</span>
            </div>
        </div>
    </div>
</section>

<section class="container search-panel">
    <?php renderSearchForm($keyword, baseUrl()); ?>
</section>

<section class="container recipe-section">
    <h2>Công thức mới nhất</h2>
    <?php renderRecipeCards($recipes); ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
