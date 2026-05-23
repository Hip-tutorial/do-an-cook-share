<?php
  require __DIR__ . '/../Config/connect.php'; 

  // Lấy ID từ đường link (VD: product.php?id=3)
  if (isset($_GET['id'])) {
      $id = $_GET['id'];
  } else {
      $id = 1; // Nếu không bấm gì, mặc định mở áo thun số 1
  }

  // Vào kho tìm đúng món đồ
  $sql = "SELECT * FROM products WHERE id = " . $id;
  $result = $conn->query($sql);
  $product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $product['name']; ?> - ZENIQ STUDIO</title>
<link rel="stylesheet" type="text/css" href="../Public/Css/Product.css?v=4">
<link rel="stylesheet" type="text/css" href="Public/Css/Profile.css">

</head>
<body>

<header>
  <a href="../index.php" class="logo">ZENIQ STUDIO</a>   
  <div class="header-icons">
    <a href="#" id="btn-login">Đăng ký / Đăng nhập</a>
    <div id="user-info" style="display: none; align-items: center; gap: 10px;">
      <a href="../profile.php" id="user-name" style="font-weight: bold; text-decoration: underline; color: black;" title="Xem lịch sử mua hàng"></a>
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

<div class="breadcrumb">
  <a href="../index.php">Trang chủ</a> / <span><?php echo $product['name']; ?></span>
</div>

<div class="container">
  <div class="product-layout">
    
    <div class="product-images">
      <img src="../<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>" class="main-image">
      <div class="thumbnail-images">
        <img src="../<?php echo $product['thumb1']; ?>" class="thumbnail">
        <img src="../<?php echo $product['thumb2']; ?>" class="thumbnail">
        <img src="../<?php echo $product['thumb3']; ?>" class="thumbnail">
        <img src="../<?php echo $product['thumb4']; ?>" class="thumbnail">
      </div>
    </div>

    <div class="product-info">
      <h1 class="product-title"><?php echo $product['name']; ?></h1>
      <div class="product-code-detail" style="font-size: 14px; color: #555; margin-bottom: 10px;">
        Mã sản phẩm: <strong class="item-code"><?php echo $product['product_code']; ?></strong>
      </div>
      
      <div class="price-section">
        <div class="price-display">
          <span class="price-current"><?php echo number_format($product['price_current']); ?> VND</span>
          <span class="price-original"><?php echo number_format($product['price_original']); ?> VND</span>
          <span class="discount-badge"><?php echo $product['discount']; ?></span>
        </div>
        <div class="price-note">Giá đã bao gồm VAT. Miễn phí vận chuyển cho đơn hàng từ 500,000 VND.</div>
      </div>

      <div class="stock-status in-stock">
        <span class="stock-status-label">✓ Còn hàng (<?php echo $product['stock_count']; ?> sản phẩm có sẵn)</span>
      </div>

      <?php if (!empty($product['size_guide_html'])) { ?>
      <div class="size-guide">
        <div class="size-guide-title">Hướng dẫn chọn size</div>
        <table class="size-guide-table">
          <?php echo $product['size_guide_html']; ?>
        </table>
      </div>
      <?php } ?>

      <div class="selectors">
        <div class="selector-group">
          <label class="selector-label">Chọn Size *</label>
          <select class="size-selector">
            <option value="">-- Vui lòng chọn size --</option>
            <?php 
              $sizes = explode(',', $product['sizes_list']);
              foreach($sizes as $s) {
                $s = trim($s);
                if($s === 'one-size') {
                   echo "<option value='one-size'>One Size</option>";
                } else {
                   echo "<option value='$s'>$s</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="selector-group">
          <label class="selector-label">Chọn Màu *</label>
          <select class="color-selector">
            <option value="">-- Vui lòng chọn màu --</option>
            <?php 
              $colors = explode(',', $product['colors_list']);
              foreach($colors as $c) {
                $parts = explode(':', $c);
                $val = trim($parts[0]);
                $label = trim($parts[1]);
                echo "<option value='$val'>$label</option>";
              }
            ?>
          </select>
        </div>

        <div class="selector-group">
          <label class="selector-label">Số lượng *</label>
          <input type="number" class="quantity-selector" value="1" min="1" max="99" style="width: 120px; padding: 12px; border: 1px solid #ccc; font-size: 14px; text-align: center;">
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-buy">Mua ngay</button>
        <button class="btn btn-cart">Thêm vào giỏ</button>
      </div>

      <div class="description-section">
        <h2 class="description-title">Mô tả sản phẩm</h2>
        <div class="description-content">
          <p><?php echo $product['desc_intro']; ?></p>
          <p style="margin-top: 15px;"><strong>Đặc điểm nổi bật:</strong></p>
          <ul>
            <?php echo $product['desc_features']; ?>
          </ul>
          <p style="margin-top: 15px;"><strong>Hướng dẫn bảo quản:</strong></p>
          <ul>
            <?php echo $product['desc_care']; ?>
          </ul>
        </div>
      </div>
    </div>
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

<script src="../Public/Javascript/Search.js"></script>
<script src="../Public/Javascript/Filter&Purchase.js?=v1"></script>
<script src="../Public/Javascript/Register&Login.js?=v4"></script>

</body>
</html>
<?php 
  // Đóng kết nối SQL
  $conn->close(); 
?>