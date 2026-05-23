function cancelOrder(orderId) {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng #' + orderId + ' không?')) return;

    let formData = new FormData();
    formData.append('order_id', orderId);

    // Vô hiệu hóa nút, tránh bấm nhiều lần
    const btn = event.target;
    const oldText = btn.innerText;
    btn.innerText = 'Đang xử lý...';
    btn.disabled = true;

    fetch('Config/cancel_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Bạn đã hủy đơn hàng thành công!');
            location.reload(); // Tự động tải lại trang để cập nhật chữ "Đã hủy"
        } else {
            alert(data.message);
            btn.innerText = oldText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Lỗi kết nối máy chủ!');
        btn.innerText = oldText;
        btn.disabled = false;
    });
}
