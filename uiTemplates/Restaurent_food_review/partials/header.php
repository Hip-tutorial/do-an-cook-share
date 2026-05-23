<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <title>Food Review</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<header class="header">

    <nav class="navbar">

        <!-- LOGO -->

        <a href="index.php" class="logo">
            🍔 FoodReview
        </a>

        <!-- MENU -->

        <ul class="nav-menu">

            <li>
                <a href="index.php">
                    Trang chủ
                </a>
            </li>

            <?php if(isset($_SESSION['user'])): ?>

                <li>
                    <a href="create_post.php">
                        Đăng bài
                    </a>
                </li>

                <li class="user-box">
                    👤 <?= $_SESSION['user']['username'] ?>
                </li>

                <li>
                    <a href="logout.php"
                       class="logout-btn">
                        Đăng xuất
                    </a>
                </li>

            <?php else: ?>

                <li>
                    <a href="login.php">
                        Đăng nhập
                    </a>
                </li>

                <li>
                    <a href="register.php"
                       class="register-btn">
                        Đăng ký
                    </a>
                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>