<?php

/**
 * Fetch recipes with optional search keyword.
 */
function fetchRecipes(PDO $db, string $keyword = ''): array
{
    if ($keyword !== '') {
        $stmt = $db->prepare(
            'SELECT r.*, u.fullname AS author_name
             FROM recipes r
             JOIN users u ON r.user_id = u.id
             WHERE r.title LIKE :keyword
             ORDER BY r.created_at DESC'
        );
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
    } else {
        $stmt = $db->query(
            'SELECT r.*, u.fullname AS author_name
             FROM recipes r
             JOIN users u ON r.user_id = u.id
             ORDER BY r.created_at DESC'
        );
    }

    return $stmt->fetchAll();
}

function renderRecipeCards(array $recipes): void
{
    if (empty($recipes)) {
        echo '<p class="empty-message">Không tìm thấy công thức nào phù hợp.</p>';
        return;
    }

    echo '<div class="recipe-grid">';
    foreach ($recipes as $recipe) {
        ?>
        <article class="recipe-card">
            <a class="recipe-card-media" href="<?= baseUrl('pages/recipe-detail.php?id=' . (int) $recipe['id']) ?>">
                <img src="<?= e(imageUrl($recipe['image'])) ?>" alt="<?= e($recipe['title']) ?>">
            </a>
            <div class="recipe-card-body">
                <p class="recipe-author">Từ bếp của <?= e($recipe['author_name']) ?></p>
                <h3><?= e($recipe['title']) ?></h3>
                <p class="recipe-desc"><?= e($recipe['description']) ?></p>
                <a class="btn btn-primary" href="<?= baseUrl('pages/recipe-detail.php?id=' . (int) $recipe['id']) ?>">
                    Xem công thức
                </a>
            </div>
        </article>
        <?php
    }
    echo '</div>';
}

function renderSearchForm(string $keyword, string $action): void
{
    ?>
    <form class="search-form" method="GET" action="<?= e($action) ?>">
        <label class="sr-only" for="recipe-search">Tìm kiếm công thức</label>
        <input id="recipe-search" type="text" name="q" placeholder="Tìm kiếm theo tên món..." value="<?= e($keyword) ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <?php
}
