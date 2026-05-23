<?php
  session_start();
  require __DIR__ . '/Config/connect.php';

  // 1. Kiểm tra đăng nhập, nếu chưa thì đá về trang chủ
  if (!isset($_SESSION['user_id'])) {
      header("Location: index.php");
      exit();
  }

  $user_id = $_SESSION['user_id'];
  // Tự động kiểm tra và lấy tên, nếu không có thì để mặc định là 'Bạn'
  $user_name = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : (isset($_SESSION['name']) ? $_SESSION['name'] : 'Bạn'); 

  // 2. Lấy danh sách hóa đơn của khách hàng này (Sắp xếp đơn mới nhất lên đầu)
  $sql_orders = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
  $result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ZENIQ STUDIO - Trang chủ</title>

<link rel="stylesheet" type="text/css" href="Public/Css/FrontPage.css?v=2">
<link rel="stylesheet" type="text/css" href="Public/Css/Profile.css?v=1">

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

<div class="profile-container">
  <div class="profile-header">
    <h2>LỊCH SỬ MUA HÀNG CỦA BẠN</h2>
  </div>

  <?php if ($result_orders->num_rows > 0): ?>
    
    <?php while($order = $result_orders->fetch_assoc()): ?>
      <div class="order-card">
        <div class="order-header">
          <div>
            <strong>Mã đơn hàng: #<?php echo $order['id']; ?></strong><br>
            <span style="color: #666;">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
          </div>
          <div class="order-status">
             <?php echo $order['status']; ?>
             <?php if ($order['status'] === 'Chờ xử lý'): ?>
                <br>
                <button class="btn-cancel" onclick="cancelOrder(<?php echo $order['id']; ?>)" 
                        style="margin-top: 8px; padding: 6px 12px; font-size: 12px; cursor: pointer; background: #fff; border: 1px solid #d0021b; color: #d0021b; border-radius: 4px; transition: 0.3s;">
                    Hủy đơn hàng
                </button>
             <?php endif; ?>
          </div>
        </div>

        <div class="order-body">
          <?php
            //  chi tiết thông tin sản phẩm  
            $order_id = $order['id'];
            $sql_details = "SELECT od.*, p.name, p.main_image FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = '$order_id'";
            $result_details = $conn->query($sql_details);
            
            while($item = $result_details->fetch_assoc()):
          ?>
            <div class="order-item">
              <div style="display: flex; align-items: center; gap: 15px;">
                <img src="<?php echo $item['main_image']; ?>" alt="sp" style="width: 70px; height: 90px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                <div>
                  <strong style="font-size: 15px; color: #333; display: block; margin-bottom: 4px;"><?php echo $item['name']; ?></strong>
                  <span style="color: #666; font-size: 13px;">Size: <?php echo $item['size']; ?> | Màu: <?php echo $item['color']; ?></span><br>
                  <span style="font-size: 13px; color: #333; margin-top: 4px; display: inline-block;">Số lượng: <strong>x<?php echo $item['quantity']; ?></strong></span>
                </div>
              </div>

              <div style="font-weight: bold; font-size: 16px; color: #000;">
                <?php echo number_format($item['price']); ?> VND
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <div class="order-total">
          Tổng thanh toán: <span style="color: #d0021b;"><?php echo number_format($order['total_price']); ?> VND</span>
        </div>
      </div>
    <?php endwhile; ?>

  <?php else: ?>
    <div class="empty-msg">
      <p>Bạn chưa có đơn hàng nào.</p>
      <a href="index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #000; color: #fff;">Mua sắm ngay</a>
    </div>
  <?php endif; ?>

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
<script src="Public/Javascript/Filter&Purchase.js?=v2"></script>
<script src="Public/Javascript/Register&Login.js?=v3"></script>
<script src="Public/Javascript/cancel_order.js?=v1"></script>

</body>
</html>