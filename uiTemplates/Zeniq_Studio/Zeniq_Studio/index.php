<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ZENIQ STUDIO - Trang chủ</title>

<link rel="stylesheet" type="text/css" href="Public/Css/FrontPage.css?v=2">
<link rel="stylesheet" type="text/css" href="Public/Css/Profile.css">

</head>
<body>

<header>
  <a href="index.php" class="logo">ZENIQ STUDIO</a>
  <div class="header-icons">
    <a href="#" id="btn-login">Đăng nhập/Đăng ký</a>
    <div id="user-info" style="display: none; align-items: center; gap: 10px;">
      <a href="profile.php" id="user-name" style="font-weight: bold; text-decoration: underline; color: black;" title="Xem lịch sử mua hàng"></a>
      <button id="btn-logout" style="cursor:pointer; border:none; background:none; font-size:12px; color:red;">[Thoát]</button>
    </div>
    
    <!-- THANH TÌM KIẾM -->
    <div class="search-container">
      <div class="input-wrapper">
        <input type="text" placeholder="Tìm sản phẩm..." id="searchBar" autocomplete="off" />
        <span id="clearBtn" title="Xóa từ khóa">&times;</span>
      </div>
      <button type="button" id="searchBtn">Tìm</button>
      <ul id="suggestion"></ul>
    </div>

    <a href="#" id="cart-nav-btn">Giỏ hàng (<span id="cart-count">0</span>)</a>
  </div>
</header>

<!-- Gắn ID vào Slogan để đổi thông báo tìm kiếm -->
<div class="intro-banner" id="page-intro" style="background-image: url('Media/Banner/banner.png');">
  <div class="intro-overlay">
    <div class="intro-content">
      <h1 id="intro-title"> TỐI GIẢN TẠO NÊN SỰ KHÁC BIỆT</h1>
      <p id="intro-desc">Zeniq Studio mang đến phong cách tối giản, cá tính và mạnh mẽ. Chất liệu vải cao cấp, form dáng chuẩn mực dành riêng cho bạn mỗi ngày.</p>
    </div>
  </div>
</div>

<div class="filter-section">
  <select id="price-sort">
    <option value="default">Sắp xếp: Mặc định</option>
    <option value="asc">Giá: Từ thấp đến cao</option>
    <option value="desc">Giá: Từ cao đến thấp</option>
  </select>
</div>

<div class="container" >
  <div class="grid" id="product-grid">
  <?php
    require __DIR__ . '/Config/connect.php'; // Kêt nối database
    $sql = "SELECT * FROM products"; // Lấy dữ liệu sản phẩm
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
  ?>
        <div class="card product-item">
          <a href="Product/product.php?id=<?php echo $row['id']; ?>" target="_self">
            <img src="<?php echo $row['main_image']; ?>" alt="<?php echo $row['name']; ?>" class="card-img">
          </a>
          <div class="card-info">
            <a href="Product/product.php?id=<?php echo $row['id']; ?>" target="_self" class="card-title"><?php echo $row['name']; ?></a>
            <div class="product-code" style="font-size: 13px; color: #888; margin-bottom: 5px;">Mã SP: <strong class="item-code"><?php echo $row['product_code']; ?></strong></div>
            
            <div class="card-color-text"><?php echo $row['color_text_short']; ?></div>
            
            <div class="price-display">
              <span class="price-current"><?php echo number_format($row['price_current']); ?> VND</span>
              <span class="price-original"><?php echo number_format($row['price_original']); ?> VND</span>
              <span class="discount-badge"><?php echo $row['discount']; ?></span>
            </div>
            
            <div class="selectors" style="display: flex; gap: 8px; margin-bottom: 15px;">
              <select class="size-select" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 60px;">
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
              </select>
              
              <select class="color-select" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; flex: 1;">
                <option value="" disabled selected>Màu</option>
                <option value="Trắng">Trắng</option>
                <option value="Đen">Đen</option>
                <option value="Xám">Xám</option>
                <option value="Xanh">Xanh</option>
              </select>

              <input type="number" class="quantity-select" value="1" min="1" max="99" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 55px; text-align: center;">
            </div>
            <div class="card-actions">
              <button class="btn btn-buy">Mua ngay</button>
              <button class="btn btn-cart">Thêm vào giỏ</button>
            </div>
          </div>
        </div>
  <?php
      }
    }
  ?>
</div>
</div>

<footer>
  <div class="footer-col">
    <h4>Thông tin liên hệ</h4>
    <p>Hotline: 0123 456 789</p>
    <p>Email: contact@websitename.com</p>
  </div>
  <div class="footer-col">
    <h4>Địa chỉ</h4>
    <p>123 Đường ABC, Quận XYZ, HN</p>
  </div>
  <div class="footer-col">
    <h4>Mạng xã hội</h4>
    <a href="#" target="_self">Facebook</a>
    <a href="#">Instagram</a>
  </div>
</footer>

<!-- Khung đăng ký/đăng nhập -->
<div id="auth-modal" class="modal-overlay">
  <div class="modal-box">
    <span id="close-modal" class="close-btn">&times;</span>
    <h3 id="modal-title" style="text-align: center; margin-bottom: 20px;">ĐĂNG NHẬP</h3>
    
    <div class="input-group" id="name-group" style="display: none;">
      <input type="text" id="fullname" class="input-field" placeholder="Nhập Họ và tên của bạn">
    </div>

    <div class="input-group">
      <input type="email" id="email" class="input-field" placeholder="Nhập Email">
    </div>
    
    <div class="input-group">
      <input type="password" id="password" class="input-field" placeholder="Nhập Mật khẩu">
      <span id="toggle-eye" class="eye-icon">👁️</span>
    </div>
    
    <a href="#" id="forgot-pw-link" class="forgot-pw">Quên mật khẩu?</a>
    
    <button id="submit-btn" class="submit-btn">ĐĂNG NHẬP</button>
    <span id="toggle-mode-btn" class="toggle-mode" style="cursor: pointer; color: #007BFF; text-decoration: underline; display: block; text-align: center; margin-top: 15px;">Chưa có tài khoản? Đăng ký ngay</span>
  </div>
</div>

<!-- khung giỏ hàng -->
<div id="cart-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
  <div style="background: white; width: 90%; max-width: 500px; margin: 50px auto; padding: 30px; border-radius: 8px; position: relative; max-height: 80vh; overflow-y: auto;">
    <span id="close-cart-modal" style="position: absolute; right: 15px; top: 10px; cursor: pointer; font-size: 24px;">&times;</span>
    <h3 style="margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px;">GIỎ HÀNG CỦA BẠN</h3>
    <ul id="cart-items" style="list-style: none;"></ul>
    <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #000; text-align: right;">
      <h3 style="color: #D0021B;">Tổng cộng: <span id="cart-total-price">0</span> VND</h3>
    </div>
    <button id="btn-proceed-checkout" style="width: 100%; padding: 15px; background: black; color: white; border: none; cursor: pointer; font-weight: bold; margin-top: 20px; text-transform: uppercase;">Tiến hành thanh toán</button>
  </div>
</div>

<!-- khung thanh toán -->
<div id="checkout-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1001;">
  <div style="background: white; width: 90%; max-width: 500px; margin: 50px auto; padding: 30px; border-radius: 8px; position: relative; max-height: 80vh; overflow-y: auto; text-align: center;">
    <span id="close-checkout-modal" style="position: absolute; right: 15px; top: 10px; cursor: pointer; font-size: 24px;">&times;</span>
    <h3 style="margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px;">THÔNG TIN GIAO HÀNG</h3>
    <div class="form-group"><label>Họ và tên *</label><input type="text" id="checkout-name"></div>
    <div class="form-group"><label>Số điện thoại *</label><input type="tel" id="checkout-phone"></div>
    <div class="form-group"><label>Địa chỉ nhận hàng *</label><textarea id="checkout-address" rows="3"></textarea></div>
    <div class="form-group"><label>Phương thức thanh toán</label><select id="checkout-method"><option value="cod">Thanh toán khi nhận hàng (COD)</option></select></div>
    <div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border: 1px solid #eee; border-radius: 4px; text-align: left;">
      <p style="font-size: 14px; color: #555;">Tổng thanh toán: <strong style="color: #D0021B; font-size: 18px;"><span id="checkout-total-price">0</span> VND</strong></p>
    </div>
    <button id="btn-confirm-order" style="width: 100%; padding: 15px; background: #D0021B; color: white; border: none; cursor: pointer; font-weight: bold; text-transform: uppercase; font-size: 15px; border-radius: 4px;">Xác nhận đặt hàng</button>
  </div>
</div>

<script src="Public/Javascript/Search.js?=v3"></script>
<script src="Public/Javascript/Filter&Purchase.js?=v1"></script>
<script src="Public/Javascript/Register&Login.js?=v3"></script>

</body>
</html>