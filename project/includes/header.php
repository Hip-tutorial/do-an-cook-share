<?php
require_once __DIR__ . '/auth.php';

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$homeBase = rtrim(appBasePath(), '/') ?: '';
$isHome = rtrim($currentPath, '/') === $homeBase
    || rtrim($currentPath, '/') === ($homeBase === '' ? 'index.php' : $homeBase . '/index.php');
$isRecipes = str_contains($currentPath, '/pages/recipes.php') || str_contains($currentPath, '/pages/recipe-detail.php');
$isAddRecipe = str_contains($currentPath, '/pages/add-recipe.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Chia sẻ công thức nấu ăn') ?></title>
    <link rel="stylesheet" href="<?= baseUrl('assets/css/style.css') ?>">
</head>
<body class="app-shell">
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="<?= baseUrl() ?>" aria-label="CookShare">
                <span class="logo-mark">CS</span>
                <span class="logo-text">
                    <strong>CookShare</strong>
                    <small>Bếp nhà & cộng đồng</small>
                </span>
            </a>
            <nav class="main-nav">
                <a class="nav-link <?= $isHome ? 'is-active' : '' ?>" href="<?= baseUrl() ?>">Trang chủ</a>
                <a class="nav-link <?= $isRecipes ? 'is-active' : '' ?>" href="<?= baseUrl('pages/recipes.php') ?>">Công thức</a>
                <a class="nav-link <?= $isAddRecipe ? 'is-active' : '' ?>" href="<?= baseUrl('pages/add-recipe.php') ?>">Chia sẻ</a>
                <?php if (isLoggedIn()): ?>
                    <span class="user-greeting">Xin chào, <?= e(getCurrentUserName()) ?></span>
                    <a class="nav-link nav-link-muted" href="<?= baseUrl('pages/logout.php') ?>">Đăng xuất</a>
                <?php else: ?>
                    <a class="nav-link" href="<?= baseUrl('pages/login.php') ?>">Đăng nhập</a>
                    <a href="<?= baseUrl('pages/register.php') ?>" class="btn-nav">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="site-main">
