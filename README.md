# CookShare - Website chia sẻ công thức nấu ăn

CookShare là đồ án website chia sẻ công thức nấu ăn xây dựng bằng **PHP thuần + MySQL**. Dự án có giao diện lấy cảm hứng từ mẫu `uiTemplates/UI-1`, tập trung vào trang chủ đẹp, danh sách công thức rõ ràng, chi tiết món ăn và bình luận từ người dùng.

## Công nghệ sử dụng

- HTML, CSS, JavaScript
- PHP 8.2 chạy trên Apache
- MySQL 8.0
- Docker Compose
- PDO, Session, `password_hash` / `password_verify`

## Chức năng chính

- Xem danh sách công thức nấu ăn
- Tìm kiếm công thức theo tên món
- Đăng ký và đăng nhập người dùng
- Chia sẻ công thức mới kèm ảnh upload
- Xem chi tiết nguyên liệu, cách chế biến
- Bình luận / góp ý cho công thức khi đã đăng nhập

## Cấu trúc thư mục

```text
do-an-cook-share/
├── docker-compose.yml
├── Dockerfile
├── database/
│   ├── init.sql          # Tạo bảng users, recipes, comments
│   └── seed_demo.sql     # Dữ liệu demo: 2 user, 10 công thức, bình luận
├── project/
│   ├── index.php
│   ├── config/database.php
│   ├── includes/
│   ├── pages/
│   ├── assets/
│   └── uploads/
│       ├── .gitkeep
│       └── seed/         # Ảnh mẫu dùng cho dữ liệu seed
└── requirement.md
```

## Chạy dự án bằng Docker

Từ thư mục gốc dự án:

```bash
docker compose up -d --build
```

Truy cập website:

```text
http://localhost:8081
```

Kiểm tra container:

```bash
docker compose ps
```

Dừng container:

```bash
docker compose down
```

Xóa sạch volume database để tạo DB mới từ đầu:

```bash
docker compose down -v
```

## Thông tin database

| Thông tin | Giá trị |
|---|---|
| Host trong Docker | `db` |
| Host từ máy local | `localhost` |
| Port | `3306` |
| Database | `recipe_db` |
| User | `recipe_user` |
| Password | `recipe_pass` |
| Root password | `root_pass` |

## Import dữ liệu seed bằng CLI Docker

File `database/seed_demo.sql` dùng cho demo và sẽ **xóa dữ liệu hiện có** trong 3 bảng `comments`, `recipes`, `users` trước khi insert dữ liệu mẫu.

### Cách khuyến nghị trên mọi shell

Chạy Docker trước:

```bash
docker compose up -d --build
```

Copy file seed vào container MySQL:

```bash
docker compose cp database/seed_demo.sql db:/tmp/seed_demo.sql
```

Import seed:

```bash
docker compose exec db mysql --default-character-set=utf8mb4 -urecipe_user -precipe_pass recipe_db -e "source /tmp/seed_demo.sql"
```

Kiểm tra nhanh dữ liệu:

```bash
docker compose exec db mysql --default-character-set=utf8mb4 -urecipe_user -precipe_pass recipe_db -e "SELECT id, username, fullname FROM users; SELECT id, user_id, title, image FROM recipes;"
```

### Cách dùng redirection trên Git Bash / Linux / macOS

```bash
docker compose exec -T db mysql --default-character-set=utf8mb4 -urecipe_user -precipe_pass recipe_db < database/seed_demo.sql
```

## Import database bằng phpMyAdmin trên máy khác

1. Mở phpMyAdmin.
2. Tạo database mới tên `recipe_db`.
3. Chọn charset/collation UTF-8, ví dụ `utf8mb4_unicode_ci`.
4. Chọn database `recipe_db`.
5. Vào tab **Import**, chọn file `database/init.sql`, bấm **Import** để tạo bảng.
6. Tiếp tục vào tab **Import**, chọn file `database/seed_demo.sql`, bấm **Import** để thêm dữ liệu demo.
7. Kiểm tra 3 bảng:

```sql
SELECT * FROM users;
SELECT * FROM recipes;
SELECT * FROM comments;
```

## Tài khoản demo

| User ID | Họ tên | Username | Email | Mật khẩu |
|---:|---|---|---|---|
| 1 | Nguyễn Mai An | `maian` | `maian@cookshare.local` | `123456` |
| 2 | Trần Nam Bếp | `nambep` | `nambep@cookshare.local` | `123456` |

## Dữ liệu seed

| ID | Công thức | Người đăng | Ảnh |
|---:|---|---|---|
| 1 | Pizza phô mai kéo sợi | Nguyễn Mai An | `seed/pizza.jpg` |
| 2 | Phở bò tái thơm gừng | Nguyễn Mai An | `seed/pho.jpg` |
| 3 | Lẩu nấm chua cay | Nguyễn Mai An | `seed/kichi.jpg` |
| 4 | Cà phê sữa đá kem muối | Nguyễn Mai An | `seed/coffee.jpg` |
| 5 | Bữa tiệc gia đình cuối tuần | Nguyễn Mai An | `seed/anhnhahang.jpg` |
| 6 | Bò nướng kiểu Hàn tại nhà | Trần Nam Bếp | `seed/gogi.jpg` |
| 7 | Lẩu Đài Loan cay nhẹ | Trần Nam Bếp | `seed/manwah.jpg` |
| 8 | Mì Ý sốt bò bằm | Trần Nam Bếp | `seed/pizza.jpg` |
| 9 | Phở cuốn thịt bò | Trần Nam Bếp | `seed/pho.jpg` |
| 10 | Gà áp chảo sốt cam | Trần Nam Bếp | `seed/kichi.jpg` |

Seed cũng tạo 12 bình luận mẫu để trang chi tiết công thức có nội dung trao đổi giữa 2 tài khoản demo.

## Các URL chính

| URL | Chức năng |
|---|---|
| `/` | Trang chủ, hero, tìm kiếm, công thức mới nhất |
| `/pages/recipes.php` | Danh sách công thức |
| `/pages/recipe-detail.php?id=1` | Chi tiết công thức và bình luận |
| `/pages/add-recipe.php` | Chia sẻ công thức, yêu cầu đăng nhập |
| `/pages/register.php` | Đăng ký |
| `/pages/login.php` | Đăng nhập |
| `/pages/logout.php` | Đăng xuất |

## Kịch bản trình bày đồ án

### 1. Giới thiệu tổng quan

- Tên đề tài: Website chia sẻ công thức nấu ăn CookShare.
- Mục tiêu: người dùng có thể xem, tìm kiếm, chia sẻ và góp ý công thức.
- Công nghệ: PHP thuần, MySQL, HTML/CSS/JS, Docker Compose.

### 2. Trình bày kiến trúc

```text
Browser -> Apache/PHP container -> MySQL container
                         |
                         -> project/uploads lưu ảnh upload và ảnh seed
```

- Frontend: HTML, CSS, JavaScript validate form.
- Backend: PHP xử lý request, session đăng nhập, PDO truy vấn MySQL.
- Database: 3 bảng `users`, `recipes`, `comments`.
- Bảo mật cơ bản: prepared statement, escape output bằng `htmlspecialchars`, mật khẩu hash.

### 3. Demo chức năng

1. Mở `http://localhost:8081`.
2. Giới thiệu trang chủ, hero, danh sách công thức mới nhất.
3. Tìm kiếm món, ví dụ `phở`, `pizza`, `lẩu`.
4. Đăng nhập bằng `maian` / `123456`.
5. Vào chi tiết công thức, gửi bình luận.
6. Vào trang chia sẻ công thức, nhập món mới và upload ảnh.
7. Đăng xuất, vào lại chi tiết để cho thấy người chưa đăng nhập không gửi được bình luận.

### 4. Demo database

Chạy trong CLI:

```bash
docker compose exec db mysql --default-character-set=utf8mb4 -urecipe_user -precipe_pass recipe_db
```

Các câu lệnh SQL minh họa:

```sql
SELECT id, fullname, username FROM users;
SELECT id, user_id, title, image FROM recipes;
SELECT id, recipe_id, user_id, content FROM comments;
```

Giải thích quan hệ:

- `recipes.user_id` tham chiếu `users.id`.
- `comments.recipe_id` tham chiếu `recipes.id`.
- `comments.user_id` tham chiếu `users.id`.

## Xử lý lỗi thường gặp

| Lỗi | Cách xử lý |
|---|---|
| Port `8081` bị chiếm | Đổi port trong `docker-compose.yml`, ví dụ `"8082:80"` |
| Database chưa có bảng | Import `database/init.sql` hoặc chạy lại Docker với volume mới |
| Muốn reset dữ liệu demo | Import lại `database/seed_demo.sql` |
| Ảnh upload không lưu được | Kiểm tra quyền ghi thư mục `project/uploads` |
| MySQL chưa sẵn sàng | Chạy `docker compose ps`, đợi service `db` healthy |

## Ghi chú

- Dự án bám đúng yêu cầu đồ án, không có admin, phân trang hay CRUD nâng cao.
- Ảnh demo nằm trong `project/uploads/seed/` để dữ liệu seed hoạt động ngay sau khi import.
- File `database/seed_demo.sql` chỉ dùng cho demo vì có thao tác reset dữ liệu trong 3 bảng chính.
