<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/recipes.php';

$pageTitle = 'Danh sách công thức';
$keyword = trim($_GET['q'] ?? '');

$db = getDB();
$recipes = fetchRecipes($db, $keyword);

require_once __DIR__ . '/../includes/header.php';
?>

<section class="container page-header">
    <span class="eyebrow">Thư viện món ngon</span>
    <h1>Danh sách công thức</h1>
    <p>Tìm món ăn theo tên, xem nhanh mô tả và mở chi tiết để đọc nguyên liệu, cách chế biến, bình luận.</p>
</section>

<section class="container search-panel">
    <?php renderSearchForm($keyword, baseUrl('pages/recipes.php')); ?>
</section>

<section class="container recipe-section">
    <?php renderRecipeCards($recipes); ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
