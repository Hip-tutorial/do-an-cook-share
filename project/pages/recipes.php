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

<section class="page-header">
    <h1>Danh sách công thức</h1>
</section>

<?php renderSearchForm($keyword, baseUrl('pages/recipes.php')); ?>

<section class="recipe-section">
    <?php renderRecipeCards($recipes); ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
