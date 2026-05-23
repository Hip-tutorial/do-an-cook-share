<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) {
    header('Location: /');
    exit;
}

$pageTitle = 'Đăng nhập';
$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];

            header('Location: /');
            exit;
        }

        $errors[] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
    }
}

$successMessage = isset($_GET['registered']) ? 'Đăng ký thành công! Vui lòng đăng nhập.' : '';

require_once __DIR__ . '/../includes/header.php';
?>

<section class="form-section">
    <span class="eyebrow">Thành viên CookShare</span>
    <h1>Đăng nhập</h1>
    <p class="form-intro">Truy cập tài khoản để chia sẻ công thức và gửi bình luận cho món ăn yêu thích.</p>

    <?php if ($successMessage !== ''): ?>
        <p class="alert alert-success"><?= e($successMessage) ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <ul class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form class="auth-form" id="login-form" method="POST" action="" novalidate>
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" value="<?= e($username) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        <p class="form-link">Chưa có tài khoản? <a href="<?= baseUrl('pages/register.php') ?>">Đăng ký</a></p>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
