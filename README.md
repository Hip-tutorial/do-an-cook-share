# CookShare — Website chia sẻ công thức nấu ăn

Website đồ án xây dựng bằng **PHP thuần + MySQL**, chạy local qua **Docker Compose**.

## Công nghệ sử dụng

- HTML, CSS, JavaScript
- PHP 8.2 (Apache)
- MySQL 8.0
- Docker & Docker Compose

## Yêu cầu hệ thống

- [Docker](https://docs.docker.com/get-docker/) và Docker Compose
- Git (tùy chọn, để clone mã nguồn)

## Cấu trúc thư mục

```
do-an-php/
├── docker-compose.yml      # Cấu hình Docker (web + db)
├── Dockerfile              # Image PHP Apache
├── database/init.sql       # Script tạo bảng MySQL
├── .env.example            # Mẫu biến môi trường
└── project/                # Mã nguồn website
    ├── index.php           # Trang chủ
    ├── config/database.php # Kết nối PDO
    ├── includes/           # Header, footer, auth, helper
    ├── pages/              # Các trang chức năng
    ├── assets/             # CSS, JS, ảnh tĩnh
    └── uploads/            # Ảnh công thức upload
```

## Chạy dự án trên máy local

### Bước 1: Clone hoặc mở thư mục dự án

```bash
cd do-an-php
```

### Bước 2: Cấp quyền ghi cho thư mục upload

Thư mục `uploads/` cần quyền ghi để Apache lưu ảnh công thức:

```bash
chmod 777 project/uploads
```

### Bước 3: Khởi chạy Docker

```bash
docker compose up -d --build
```

Lần chạy đầu tiên Docker sẽ:
- Build image PHP Apache
- Tải image MySQL 8.0
- Tạo database và 3 bảng từ `database/init.sql`

### Bước 4: Truy cập website

Mở trình duyệt:

```
http://localhost:8081
```

> **Lưu ý:** Dự án map port **8081** (host) → **80** (container).  
> Nếu port 8081 bị chiếm, sửa `ports` trong `docker-compose.yml` (ví dụ `"8082:80"`) rồi chạy lại `docker compose up -d`.

### Bước 5: Kiểm tra container đang chạy

```bash
docker compose ps
```

Kết quả mong đợi: service `web` và `db` đều ở trạng thái **Up**, `db` **healthy**.

### Dừng dự án

```bash
docker compose down
```

Dữ liệu MySQL vẫn được giữ trong Docker volume `mysql_data`. Muốn xóa sạch dữ liệu:

```bash
docker compose down -v
```

## Thông tin kết nối database

| Thông tin | Giá trị |
|-----------|---------|
| Host (trong Docker) | `db` |
| Host (từ máy local) | `localhost` |
| Port | `3306` |
| Database | `recipe_db` |
| User | `recipe_user` |
| Password | `recipe_pass` |
| Root password | `root_pass` |

Kết nối bằng MySQL client (tùy chọn):

```bash
docker exec -it do-an-php-db-1 mysql -urecipe_user -precipe_pass recipe_db
```

## Các trang chính

| URL | Chức năng |
|-----|-----------|
| `/` | Trang chủ — danh sách công thức, tìm kiếm |
| `/pages/recipes.php` | Danh sách công thức |
| `/pages/recipe-detail.php?id=1` | Chi tiết công thức + bình luận |
| `/pages/add-recipe.php` | Chia sẻ công thức (cần đăng nhập) |
| `/pages/register.php` | Đăng ký tài khoản |
| `/pages/login.php` | Đăng nhập |
| `/pages/logout.php` | Đăng xuất |

## Luồng trình bày đồ án (demo)

Dưới đây là kịch bản demo gợi ý khi bảo vệ, bám sát đúng yêu cầu đề bài.

### 1. Giới thiệu tổng quan (1–2 phút)

- **Mục tiêu:** Website chia sẻ công thức nấu ăn
- **Chức năng chính:**
  - Xem và tìm kiếm công thức
  - Đăng ký / đăng nhập thành viên
  - Chia sẻ công thức mới (có upload ảnh)
  - Góp ý / bình luận về công thức
- **Công nghệ:** PHP thuần, MySQL, HTML/CSS/JS, Docker

### 2. Trình bày kiến trúc hệ thống (2–3 phút)

```
Trình duyệt → Apache/PHP (container web) → MySQL (container db)
                              ↓
                        uploads/ (lưu ảnh)
```

- **Frontend:** HTML, CSS, JavaScript (validate form phía client)
- **Backend:** PHP xử lý logic, Session quản lý đăng nhập
- **Database:** 3 bảng `users`, `recipes`, `comments`
- **Bảo mật cơ bản:** `password_hash`, prepared statement (PDO), `htmlspecialchars`

### 3. Demo chức năng (5–7 phút)

Thực hiện tuần tự trên trình duyệt:

#### Bước A — Trang chủ & tìm kiếm

1. Mở `http://localhost:8081`
2. Giới thiệu header: Trang chủ, Công thức, Chia sẻ, Đăng nhập/Đăng ký
3. Giải thích danh sách công thức: ảnh, tên món, mô tả, người đăng
4. Demo **tìm kiếm theo tên món** trên thanh search

#### Bước B — Đăng ký & đăng nhập

1. Vào **Đăng ký**, nhập:
   - Họ tên, email, username, mật khẩu, xác nhận mật khẩu
2. Giải thích **validate JavaScript** (không để trống, email đúng định dạng, mật khẩu khớp)
3. Submit → hệ thống lưu user vào MySQL (mật khẩu đã hash)
4. **Đăng nhập** bằng username vừa tạo → session được tạo, header hiện "Xin chào, ..."

#### Bước C — Chia sẻ công thức

1. Vào **Chia sẻ công thức**
2. Nhập: tên món, mô tả, nguyên liệu, cách chế biến
3. **Upload ảnh** món ăn (JPG/PNG/WEBP, tối đa 2MB)
4. Submit → dữ liệu lưu vào bảng `recipes`, ảnh lưu trong `uploads/`
5. Quay lại trang chủ → công thức mới xuất hiện

#### Bước D — Xem chi tiết & bình luận

1. Bấm **Xem chi tiết** một công thức
2. Trình bày: tên món, ảnh, người đăng, nguyên liệu, cách làm
3. Phần **góp ý / bình luận:**
   - Đăng xuất → vào lại trang chi tiết → **không gửi được bình luận** (chỉ hiện thông báo đăng nhập)
   - Đăng nhập lại → nhập bình luận → gửi → hiện trong danh sách

#### Bước E — Trang danh sách công thức

1. Vào menu **Công thức**
2. Demo lại tìm kiếm và xem chi tiết

### 4. Trình bày database (2–3 phút)

Mở MySQL và show 3 bảng:

```sql
SELECT * FROM users;
SELECT * FROM recipes;
SELECT * FROM comments;
```

Giải thích quan hệ:
- `recipes.user_id` → `users.id` (ai đăng công thức)
- `comments.recipe_id` → `recipes.id` (bình luận thuộc công thức nào)
- `comments.user_id` → `users.id` (ai bình luận)

### 5. Kết luận & Q&A (1–2 phút)

- Tóm tắt: đã đáp ứng đủ yêu cầu đề (đăng bài, chia sẻ, góp ý)
- Nêu hướng mở rộng có thể làm thêm (nếu giảng viên hỏi): sửa/xóa công thức, phân trang, admin...

## Xử lý lỗi thường gặp

| Lỗi | Cách xử lý |
|-----|------------|
| Port bị chiếm | Đổi port trong `docker-compose.yml`, chạy lại `docker compose up -d` |
| Upload ảnh thất bại | Chạy `chmod 777 project/uploads` |
| Trang trắng / lỗi DB | Kiểm tra `docker compose ps`, đợi MySQL healthy rồi refresh |
| Muốn reset database | `docker compose down -v` rồi `docker compose up -d --build` |

## Tài khoản demo (tùy chọn)

Sau khi chạy dự án, tự tạo tài khoản qua trang **Đăng ký** để demo. Không có tài khoản mặc định sẵn trong database.

## Tài liệu tham khảo

- Chi tiết yêu cầu đề bài: [requirement.md](requirement.md)
