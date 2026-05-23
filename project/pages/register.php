<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

$pageTitle = 'Đăng ký';
$errors = [];
$old = [
    'fullname' => '',
    'email' => '',
    'username' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['fullname'] = trim($_POST['fullname'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['username'] = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Server-side validation
    if ($old['fullname'] === '') {
        $errors[] = 'Họ tên không được để trống.';
    }
    if ($old['email'] === '') {
        $errors[] = 'Email không được để trống.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không đúng định dạng.';
    }
    if ($old['username'] === '') {
        $errors[] = 'Tên đăng nhập không được để trống.';
    }
    if ($password === '') {
        $errors[] = 'Mật khẩu không được để trống.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Xác nhận mật khẩu không khớp.';
    }

    if (empty($errors)) {
        $db = getDB();

        // Check duplicate username
        $stmt = $db->prepare('SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1');
        $stmt->execute(['username' => $old['username'], 'email' => $old['email']]);
        if ($stmt->fetch()) {
            $errors[] = 'Tên đăng nhập hoặc email đã tồn tại.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $db->prepare(
                'INSERT INTO users (fullname, email, username, password) VALUES (:fullname, :email, :username, :password)'
            );
            $insert->execute([
                'fullname' => $old['fullname'],
                'email' => $old['email'],
                'username' => $old['username'],
                'password' => $hashedPassword,
            ]);

            header('Location: /pages/login.php?registered=1');
            exit;
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="form-section">
    <h1>Đăng ký tài khoản</h1>

    <?php if (!empty($errors)): ?>
        <ul class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form class="auth-form" id="register-form" method="POST" action="" novalidate>
        <div class="form-group">
            <label for="fullname">Họ tên</label>
            <input type="text" id="fullname" name="fullname" value="<?= e($old['fullname']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" value="<?= e($old['username']) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
        <p class="form-link">Đã có tài khoản? <a href="<?= baseUrl('pages/login.php') ?>">Đăng nhập</a></p>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
