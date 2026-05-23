<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

$recipeId = (int) ($_GET['id'] ?? 0);
if ($recipeId <= 0) {
    header('Location: /pages/recipes.php');
    exit;
}

$db = getDB();

// Handle comment submission
$commentErrors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    if (!isLoggedIn()) {
        header('Location: /pages/login.php');
        exit;
    }

    $content = trim($_POST['content'] ?? '');
    if ($content === '') {
        $commentErrors[] = 'Nội dung bình luận không được để trống.';
    } else {
        $stmt = $db->prepare(
            'INSERT INTO comments (recipe_id, user_id, content) VALUES (:recipe_id, :user_id, :content)'
        );
        $stmt->execute([
            'recipe_id' => $recipeId,
            'user_id' => getCurrentUserId(),
            'content' => $content,
        ]);

        header('Location: /pages/recipe-detail.php?id=' . $recipeId . '#comments');
        exit;
    }
}

// Fetch recipe
$stmt = $db->prepare(
    'SELECT r.*, u.fullname AS author_name
     FROM recipes r
     JOIN users u ON r.user_id = u.id
     WHERE r.id = :id
     LIMIT 1'
);
$stmt->execute(['id' => $recipeId]);
$recipe = $stmt->fetch();

if (!$recipe) {
    header('Location: /pages/recipes.php');
    exit;
}

// Fetch comments
$commentStmt = $db->prepare(
    'SELECT c.*, u.fullname AS author_name
     FROM comments c
     JOIN users u ON c.user_id = u.id
     WHERE c.recipe_id = :recipe_id
     ORDER BY c.created_at DESC'
);
$commentStmt->execute(['recipe_id' => $recipeId]);
$comments = $commentStmt->fetchAll();

$pageTitle = $recipe['title'];

require_once __DIR__ . '/../includes/header.php';
?>

<article class="recipe-detail">
    <div class="detail-hero">
        <img class="recipe-detail-image" src="<?= e(imageUrl($recipe['image'])) ?>" alt="<?= e($recipe['title']) ?>">
        <div class="detail-summary">
            <span class="eyebrow">Chi tiết công thức</span>
            <h1><?= e($recipe['title']) ?></h1>
            <p class="detail-meta">Người đăng: <?= e($recipe['author_name']) ?> · <?= e(date('d/m/Y', strtotime($recipe['created_at']))) ?></p>
            <p><?= e($recipe['description']) ?></p>
        </div>
    </div>

    <div class="recipe-content-grid">
        <section class="recipe-block">
            <h2>Nguyên liệu</h2>
            <div class="recipe-text"><?= nl2br(e($recipe['ingredients'])) ?></div>
        </section>

        <section class="recipe-block">
            <h2>Cách chế biến</h2>
            <div class="recipe-text"><?= nl2br(e($recipe['steps'])) ?></div>
        </section>
    </div>
</article>

<section class="comments-section" id="comments">
    <h2>Góp ý / Bình luận</h2>

    <?php if (!empty($commentErrors)): ?>
        <ul class="alert alert-error">
            <?php foreach ($commentErrors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (empty($comments)): ?>
        <p class="empty-message">Chưa có bình luận nào.</p>
    <?php else: ?>
        <ul class="comment-list">
            <?php foreach ($comments as $comment): ?>
                <li class="comment-item">
                    <strong><?= e($comment['author_name']) ?></strong>
                    <span class="comment-date"><?= e(date('d/m/Y H:i', strtotime($comment['created_at']))) ?></span>
                    <p><?= e($comment['content']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (isLoggedIn()): ?>
        <form class="comment-form" id="comment-form" method="POST" action="" novalidate>
            <div class="form-group">
                <label for="content">Viết bình luận</label>
                <textarea id="content" name="content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>
    <?php else: ?>
        <p class="alert alert-info">Vui lòng <a href="<?= baseUrl('pages/login.php') ?>">đăng nhập</a> để bình luận.</p>
    <?php endif; ?>
</section>

<p class="back-actions"><a href="<?= baseUrl('pages/recipes.php') ?>" class="btn btn-secondary">&larr; Quay lại danh sách</a></p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
