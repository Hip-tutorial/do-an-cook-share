<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$pageTitle = 'Chia sẻ công thức';
$errors = [];
$old = [
    'title' => '',
    'description' => '',
    'ingredients' => '',
    'steps' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['title'] = trim($_POST['title'] ?? '');
    $old['description'] = trim($_POST['description'] ?? '');
    $old['ingredients'] = trim($_POST['ingredients'] ?? '');
    $old['steps'] = trim($_POST['steps'] ?? '');

    if ($old['title'] === '') {
        $errors[] = 'Tên món không được để trống.';
    }
    if ($old['description'] === '') {
        $errors[] = 'Mô tả ngắn không được để trống.';
    }
    if ($old['ingredients'] === '') {
        $errors[] = 'Nguyên liệu không được để trống.';
    }
    if ($old['steps'] === '') {
        $errors[] = 'Cách chế biến không được để trống.';
    }

    $imageName = null;
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Vui lòng chọn hình ảnh món ăn.';
    } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Upload ảnh thất bại. Vui lòng thử lại.';
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($_FILES['image']['type'], $allowedTypes, true)) {
            $errors[] = 'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.';
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $errors[] = 'Ảnh không được vượt quá 2MB.';
        } else {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('recipe_', true) . '.' . strtolower($extension);
            $uploadPath = __DIR__ . '/../uploads/' . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $errors[] = 'Không thể lưu ảnh. Vui lòng thử lại.';
                $imageName = null;
            }
        }
    }

    if (empty($errors) && $imageName !== null) {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO recipes (user_id, title, image, description, ingredients, steps)
             VALUES (:user_id, :title, :image, :description, :ingredients, :steps)'
        );
        $stmt->execute([
            'user_id' => getCurrentUserId(),
            'title' => $old['title'],
            'image' => $imageName,
            'description' => $old['description'],
            'ingredients' => $old['ingredients'],
            'steps' => $old['steps'],
        ]);

        header('Location: /pages/recipe-detail.php?id=' . $db->lastInsertId());
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="form-section">
    <h1>Chia sẻ công thức</h1>

    <?php if (!empty($errors)): ?>
        <ul class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form class="auth-form" id="add-recipe-form" method="POST" action="" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <label for="title">Tên món</label>
            <input type="text" id="title" name="title" value="<?= e($old['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả ngắn</label>
            <textarea id="description" name="description" rows="3" required><?= e($old['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="ingredients">Nguyên liệu</label>
            <textarea id="ingredients" name="ingredients" rows="6" required><?= e($old['ingredients']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="steps">Cách chế biến</label>
            <textarea id="steps" name="steps" rows="8" required><?= e($old['steps']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng công thức</button>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
