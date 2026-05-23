<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Chia sẻ công thức nấu ăn') ?></title>
    <link rel="stylesheet" href="<?= baseUrl('assets/css/style.css') ?>">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="<?= baseUrl() ?>">CookShare</a>
            <nav class="main-nav">
                <a href="<?= baseUrl() ?>">Trang chủ</a>
                <a href="<?= baseUrl('pages/recipes.php') ?>">Công thức</a>
                <a href="<?= baseUrl('pages/add-recipe.php') ?>">Chia sẻ công thức</a>
                <?php if (isLoggedIn()): ?>
                    <span class="user-greeting">Xin chào, <?= e(getCurrentUserName()) ?></span>
                    <a href="<?= baseUrl('pages/logout.php') ?>">Đăng xuất</a>
                <?php else: ?>
                    <a href="<?= baseUrl('pages/login.php') ?>">Đăng nhập</a>
                    <a href="<?= baseUrl('pages/register.php') ?>" class="btn-nav">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
