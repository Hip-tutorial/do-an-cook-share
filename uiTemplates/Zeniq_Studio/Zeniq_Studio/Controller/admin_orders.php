<?php
  session_start();
  // Đã sửa: Lùi ra một cấp để vào thư mục Config
  require __DIR__ . '/../Config/connect.php';

  // Lấy toàn bộ đơn hàng, đơn mới nhất hiện lên trên
  $sql = "SELECT * FROM orders ORDER BY order_date DESC";
  $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý đơn hàng - ZENIQ Admin</title>
<link rel="stylesheet" type="text/css" href="../Public/Css/FrontPage.css">
<style>
  .admin-container { max-width: 1100px; margin: 40px auto; padding: 20px; min-height: 60vh; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
  th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
  th { background-color: #000; color: #fff; }
  tr:hover { background-color: #f9f9f9; }
  .status-select { padding: 5px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer; }
</style>
</head>
<body>

<header>
  <a href="../index.php" class="logo">ZENIQ ADMIN</a>
  <div class="header-icons">
    <span style="font-weight: bold;">Chế độ: Quản trị viên</span>
  </div>
</header>

<div class="admin-container">
  <h2>DANH SÁCH ĐƠN HÀNG TOÀN HỆ THỐNG</h2>

  <table>
    <thead>
      <tr>
        <th>Mã đơn</th>
        <th>Khách hàng</th>
        <th>SĐT / Địa chỉ</th>
        <th>Tổng tiền</th>
        <th>Ngày đặt</th>
        <th>Trạng thái</th>
      </tr>
    </thead>
    <tbody>
      <?php while($order = $result->fetch_assoc()): ?>
      <tr>
        <td>#<?php echo $order['id']; ?></td>
        <td><strong><?php echo $order['customer_name']; ?></strong></td>
        <td><?php echo $order['phone']; ?><br><small><?php echo $order['address']; ?></small></td>
        <td style="color: #d0021b; font-weight: bold;"><?php echo number_format($order['total_price']); ?> đ</td>
        <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
        <td>
          <select class="status-select" onchange="updateStatus(<?php echo $order['id']; ?>, this.value)">
            <option value="Chờ xử lý" <?php if($order['status'] == 'Chờ xử lý') echo 'selected'; ?>>Chờ xử lý</option>
            <option value="Đang giao hàng" <?php if($order['status'] == 'Đang giao hàng') echo 'selected'; ?>>Đang giao hàng</option>
            <option value="Hoàn thành" <?php if($order['status'] == 'Hoàn thành') echo 'selected'; ?>>Hoàn thành</option>
            <option value="Đã hủy" <?php if($order['status'] == 'Đã hủy') echo 'selected'; ?>>Đã hủy</option>
          </select>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
function updateStatus(orderId, newStatus) {
    let formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('status', newStatus);

    // Đã sửa: Lùi ra một cấp để gọi file xử lý PHP trong thư mục Config
    fetch('../Config/update_order_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success") {
            alert("Đã cập nhật đơn hàng #" + orderId + " thành: " + newStatus);
        } else {
            alert("Lỗi: " + data);
        }
    })
    .catch(err => console.error(err));
}
</script>

</body>
</html>