    </main>
    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <a class="footer-brand" href="<?= baseUrl() ?>">CookShare</a>
                <p>Website chia sẻ công thức nấu ăn, giúp người dùng đăng bài, tìm kiếm món ngon và góp ý qua bình luận.</p>
            </div>
            <div>
                <h3>Chức năng</h3>
                <ul>
                    <li><a href="<?= baseUrl() ?>">Trang chủ</a></li>
                    <li><a href="<?= baseUrl('pages/recipes.php') ?>">Danh sách công thức</a></li>
                    <li><a href="<?= baseUrl('pages/add-recipe.php') ?>">Chia sẻ công thức</a></li>
                </ul>
            </div>
            <div>
                <h3>Đồ án</h3>
                <p>PHP thuần, MySQL, Docker Compose, HTML, CSS và JavaScript.</p>
                <p class="footer-note">&copy; <?= date('Y') ?> CookShare.</p>
            </div>
        </div>
    </footer>
    <script src="<?= baseUrl('assets/js/validate.js') ?>"></script>
</body>
</html>
