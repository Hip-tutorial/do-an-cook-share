DỰ ÁN: WEBSITE CHIA SẺ CÔNG THỨC NẤU ĂN

MỤC TIÊU
Xây dựng website chia sẻ công thức nấu ăn gồm:
- Bài đăng công thức nấu ăn
- Chức năng chia sẻ công thức
- Chức năng góp ý về công thức

Công nghệ sử dụng:
- HTML
- CSS
- JavaScript
- PHP
- MySQL

--------------------------------------------------
1. TRANG CHỦ

Hiển thị:
- Header:
  + Trang chủ
  + Công thức
  + Chia sẻ công thức
  + Đăng nhập
  + Đăng ký

- Danh sách công thức:
  + Hình ảnh món ăn
  + Tên món ăn
  + Mô tả ngắn
  + Người đăng
  + Nút xem chi tiết

Có:
- Thanh tìm kiếm theo tên món

--------------------------------------------------
2. ĐĂNG KÝ

Form gồm:
- Họ tên
- Email
- Tên đăng nhập
- Mật khẩu
- Xác nhận mật khẩu

Validate:
- Không để trống
- Email đúng định dạng
- Username không trùng

Chức năng:
- Lưu thông tin người dùng vào MySQL

--------------------------------------------------
3. ĐĂNG NHẬP

Form gồm:
- Username
- Password

Chức năng:
- Kiểm tra dữ liệu từ MySQL
- Tạo Session đăng nhập

--------------------------------------------------
4. TRANG DANH SÁCH CÔNG THỨC

Hiển thị:
- Ảnh món ăn
- Tên món
- Mô tả ngắn
- Người đăng
- Nút xem chi tiết

Có:
- Tìm kiếm công thức

--------------------------------------------------
5. CHI TIẾT CÔNG THỨC

Hiển thị:
- Tên món
- Hình ảnh
- Người đăng
- Nguyên liệu
- Cách chế biến

Phần góp ý / bình luận:
- Hiển thị danh sách bình luận
- Ô nhập bình luận
- Nút gửi bình luận

Điều kiện:
- Chỉ người đã đăng nhập mới được bình luận

--------------------------------------------------
6. CHIA SẺ CÔNG THỨC

Form gồm:
- Tên món
- Hình ảnh
- Mô tả ngắn
- Nguyên liệu
- Cách chế biến

Chức năng:
- Upload ảnh
- Lưu dữ liệu vào MySQL

--------------------------------------------------
DATABASE

1. Bảng users
- id
- fullname
- email
- username
- password

2. Bảng recipes
- id
- user_id
- title
- image
- description
- ingredients
- steps
- created_at

3. Bảng comments
- id
- recipe_id
- user_id
- content
- created_at

--------------------------------------------------
CẤU TRÚC THƯ MỤC

project/

assets/
- css/
- js/
- images/

config/
- database.php

uploads/

pages/
- login.php
- register.php
- recipes.php
- recipe-detail.php
- add-recipe.php

includes/
- header.php
- footer.php

index.php

--------------------------------------------------
LƯU Ý CHO DEV

- Làm PHP thuần
- Không dùng framework
- UI đơn giản
- CRUD đủ theo yêu cầu đề bài
- Dùng Session cho đăng nhập
- Validate bằng JavaScript và PHP
- Comment code cơ bản để sinh viên dễ xem và vấn đáp
- Không làm chức năng ngoài yêu cầu đề bài
- Tự test lỗi trước khi bàn giao

Ghi chú:
Bản này chỉ bám sát đúng đề: bài đăng công thức, chia sẻ công thức và góp ý công thức. Không thêm admin, không thêm dashboard, không thêm tính năng nâng cao để tránh mất thời gian dev.