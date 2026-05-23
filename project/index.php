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
    <h1>Chia sẻ công thức nấu ăn</h1>
    <p>Khám phá và chia sẻ những món ngon từ cộng đồng</p>
</section>

<?php renderSearchForm($keyword, baseUrl()); ?>

<section class="recipe-section">
    <h2>Công thức mới nhất</h2>
    <?php renderRecipeCards($recipes); ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
