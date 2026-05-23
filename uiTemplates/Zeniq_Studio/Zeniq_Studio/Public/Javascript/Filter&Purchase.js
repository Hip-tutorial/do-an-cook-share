/* =========================================
   1. XỬ LÝ LỌC GIÁ SẢN PHẨM (CHỈ CHẠY Ở TRANG CHỦ)
========================================= */
const sortSelect = document.getElementById('price-sort');
const productGrid = document.getElementById('product-grid');

if(sortSelect && productGrid) {
  const defaultCards = Array.from(productGrid.querySelectorAll('.card'));
  sortSelect.addEventListener('change', function() {
    const sortType = this.value;
    let cards = Array.from(productGrid.querySelectorAll('.card'));

    if (sortType === 'default') {
      productGrid.innerHTML = '';
      defaultCards.forEach(card => productGrid.appendChild(card));
      return;
    }

    cards.sort((a, b) => {
      const priceA = parseInt(a.querySelector('.price-current').innerText.replace(/,/g, '').replace(' VND', ''));
      const priceB = parseInt(b.querySelector('.price-current').innerText.replace(/,/g, '').replace(' VND', ''));
      return sortType === 'asc' ? priceA - priceB : priceB - priceA;
    });

    productGrid.innerHTML = '';
    cards.forEach(card => productGrid.appendChild(card));
  });
}

/* =========================================
   2. XỬ LÝ GIỎ HÀNG VÀ THANH TOÁN (DÙNG CHUNG)
========================================= */
const cartNavBtn = document.getElementById('cart-nav-btn');
const cartModal = document.getElementById('cart-modal');
const closeCartModal = document.getElementById('close-cart-modal');
const checkoutModal = document.getElementById('checkout-modal');
const closeCheckoutModal = document.getElementById('close-checkout-modal');

// Hàm kiểm tra đăng nhập 
function checkLogin() {
  if (document.getElementById('user-info').style.display === 'none') {
    alert("Vui lòng đăng nhập để tiếp tục!");
    document.getElementById('auth-modal').style.display = 'block';
    return false; // Trả về false nếu chưa đăng nhập
  }
  return true; // Trả về true nếu đã đăng nhập
}
if(cartNavBtn) cartNavBtn.onclick = (e) => { 
  e.preventDefault(); 
  if (!checkLogin()) return; // Nếu chưa đăng nhập thì chặn
  cartModal.style.display = 'block'; 
}

if(closeCartModal) closeCartModal.onclick = () => cartModal.style.display = 'none';
if(closeCheckoutModal) closeCheckoutModal.onclick = () => checkoutModal.style.display = 'none';

// Hàm tải giao diện Giỏ hàng (Có thêm tính năng tự động mở Bảng thanh toán)
function updateCartUI(autoOpenCheckout = false) {
  const cartItemsList = document.getElementById('cart-items');
  const cartTotalDisplay = document.getElementById('cart-total-price');
  const cartCountHeader = document.getElementById('cart-count');

  if (!cartItemsList) return;

  const currentUrl = window.location.pathname.toLowerCase();
  const basePath = currentUrl.includes('/product/') ? '../' : './';
  const targetFile = basePath + 'Config/get_cart.php';

  fetch(targetFile)
    .then(response => response.json())
    .then(data => {
      cartItemsList.innerHTML = '';
      
      if (data.items.length === 0) {
        cartItemsList.innerHTML = '<li style="text-align:center; padding:20px;">Giỏ hàng trống</li>';
        if (cartTotalDisplay) cartTotalDisplay.innerText = '0';
        if (cartCountHeader) cartCountHeader.innerText = '0';
        return;
      }

      data.items.forEach((item) => {
        const li = document.createElement('li');
        li.style.cssText = "display: flex; align-items: center; gap: 15px; margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px;";
        
        li.innerHTML = `
          <img src="${basePath}${item.main_image}" style="width: 60px; height: 80px; object-fit: cover; border-radius: 4px;">
          <div style="flex: 1;">
            <h4 style="margin: 0; font-size: 14px;">${item.name}</h4>
            <p style="margin: 5px 0; font-size: 12px; color: #666;">Size: ${item.size} | Màu: ${item.color}</p>
            <p style="margin: 0; font-weight: bold;">${parseInt(item.price_current).toLocaleString()} VND x ${item.quantity}</p>
          </div>
          <button onclick="removeFromCart(${item.cart_id})" style="background: none; border: none; color: red; cursor: pointer; font-size: 18px;">&times;</button>
        `;
        cartItemsList.appendChild(li);
      });

      if (cartTotalDisplay) cartTotalDisplay.innerText = parseInt(data.total).toLocaleString();
      if (cartCountHeader) cartCountHeader.innerText = data.items.length;

      // NẾU LÀ "MUA NGAY", TỰ ĐỘNG MỞ BẢNG THANH TOÁN SAU KHI VẼ XONG GIỎ HÀNG
      if (autoOpenCheckout) {
         if (cartModal) cartModal.style.display = 'none';
         if (checkoutModal) checkoutModal.style.display = 'block';
         const checkoutTotalDisplay = document.getElementById('checkout-total-price');
         if (checkoutTotalDisplay) checkoutTotalDisplay.innerText = parseInt(data.total).toLocaleString();
      }
    })
    .catch(error => console.error('Lỗi lấy giỏ hàng:', error));
}

// Hàm đẩy sản phẩm lên Database
function pushItemToCart(productId, size, color, quantity = 1, isBuyNow = false) {
  let formData = new FormData();
  formData.append('product_id', productId);
  formData.append('size', size);
  formData.append('color', color);
  formData.append('quantity', quantity);

  const currentUrl = window.location.pathname.toLowerCase();
  const basePath = currentUrl.includes('/product/') ? '../' : './';
  
  fetch(basePath + 'Config/add_to_cart.php', { method: 'POST', body: formData })
  .then(response => response.text())
  .then(data => {
    const result = data.trim();
    if (result === "success") {
      // Nếu chỉ thêm giỏ hàng thì báo alert, nếu Mua Ngay thì im lặng mở bảng
      if (!isBuyNow) alert('Đã thêm sản phẩm vào giỏ hàng thành công!');
      updateCartUI(isBuyNow); 
    } else if (result === "not_logged_in") {
      alert("Vui lòng đăng nhập để thực hiện tính năng này!");
      const authModal = document.getElementById('auth-modal');
      if (authModal) authModal.style.display = 'block';
    } else {
      alert("Lỗi: " + result);
    }
  })
  .catch(error => console.error('Lỗi:', error));
}

// Hàm xóa sản phẩm
window.removeFromCart = function(cartId) {
  if (!confirm("Bạn có chắc muốn xóa món đồ này?")) return;
  let formData = new FormData();
  formData.append('cart_id', cartId);

  const currentUrl = window.location.pathname.toLowerCase();
  const basePath = currentUrl.includes('/product/') ? '../' : './';
  
  fetch(basePath + 'Config/remove_from_cart.php', { method: 'POST', body: formData })
  .then(response => response.text())
  .then(data => { if (data.trim() === "success") updateCartUI(); });
};

/* --- Xử lý Bảng Thanh Toán & Chốt đơn xuống PHP --- */
const btnProceedCheckout = document.getElementById('btn-proceed-checkout');
const btnConfirmOrder = document.getElementById('btn-confirm-order');

if(btnProceedCheckout) {
  btnProceedCheckout.onclick = () => {
    const currentCount = parseInt(document.getElementById('cart-count').innerText);
    if (currentCount === 0 || isNaN(currentCount)) {
        return alert('Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm.');
    }
    
    const currentTotal = document.getElementById('cart-total-price').innerText;
    if(document.getElementById('checkout-total-price')) {
        document.getElementById('checkout-total-price').innerText = currentTotal;
    }

    cartModal.style.display = 'none'; 
    checkoutModal.style.display = 'block'; 
  };
}

if(btnConfirmOrder) {
  btnConfirmOrder.onclick = () => {
    const name = document.getElementById('checkout-name').value.trim();
    const phone = document.getElementById('checkout-phone').value.trim();
    const address = document.getElementById('checkout-address').value.trim();
    const method = document.getElementById('checkout-method').value;

    if (!name || !phone || !address) return alert('Vui lòng điền đầy đủ các thông tin bắt buộc (*)!');

    let formData = new FormData();
    formData.append('name', name);
    formData.append('phone', phone);
    formData.append('address', address);
    formData.append('method', method);

    const currentUrl = window.location.pathname.toLowerCase();
    const basePath = currentUrl.includes('/product/') ? '../' : './';
    
    const originalText = btnConfirmOrder.innerText;
    btnConfirmOrder.innerText = 'Đang xử lý...';
    btnConfirmOrder.disabled = true;

    fetch(basePath + 'Config/process_checkout.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert(`🎉 Đặt hàng thành công!\n\nCảm ơn ${name} đã mua sắm tại cửa hàng. Chúng tôi sẽ liên hệ tới số ${phone} để giao hàng.`);
        checkoutModal.style.display = 'none';
        
        // Reset form
        document.getElementById('checkout-name').value = '';
        document.getElementById('checkout-phone').value = '';
        document.getElementById('checkout-address').value = '';
        
        updateCartUI(); 
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Lỗi thanh toán:', error);
      alert('Có lỗi xảy ra khi kết nối đến máy chủ!');
    })
    .finally(() => {
      btnConfirmOrder.innerText = originalText;
      btnConfirmOrder.disabled = false;
    });
  };
}

/* =========================================
   3. THU THẬP DỮ LIỆU TỪ GIAO DIỆN
========================================= */

// TRƯỜNG HỢP 1: TƯƠNG TÁC TẠI TRANG CHỦ (Trang index.php)
const cards = document.querySelectorAll('.card');
if(cards.length > 0) {
  cards.forEach(card => {
    const btnAddCart = card.querySelector('.btn-cart');
    const btnBuyNow = card.querySelector('.btn-buy'); // Bắt thêm nút Mua Ngay
    
    const titleLink = card.querySelector('.card-title').getAttribute('href');
    const productId = titleLink.split('id=')[1];

    // Hàm xử lý chung cho cả 2 nút
    function handlePurchase(e, isBuyNow) {
        e.preventDefault(); //Kiểm tra đăng nhập trước khi cho phép mua hàng

        if (!checkLogin()) return;
      // Thu thập số lượng, size, màu 
        const size = card.querySelector('.size-select') ? card.querySelector('.size-select').value : "";
        const color = card.querySelector('.color-select') ? card.querySelector('.color-select').value : "";
        const qtyInput = card.querySelector('.quantity-select');
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

      // Chọn size và màu sản phẩm 
        if (size === "" || color === "") {
            return alert("Vui lòng chọn đầy đủ Kích thước và Màu sắc!");
        }

        if (quantity < 1 || isNaN(quantity)) {
            return alert("Số lượng không hợp lệ!");
        }

        pushItemToCart(productId, size, color, quantity, isBuyNow);
    }

    if(btnAddCart) btnAddCart.onclick = (e) => handlePurchase(e, false);
    if(btnBuyNow) btnBuyNow.onclick = (e) => handlePurchase(e, true);
  });
}

// TRƯỜNG HỢP 2: TƯƠNG TÁC TẠI TRANG SẢN PHẨM (Trang product.php)
const productLayout = document.querySelector('.product-layout');
if(productLayout) {
  const btnAddCartDetail = productLayout.querySelector('.btn-cart');
  const btnBuyNowDetail = productLayout.querySelector('.btn-buy'); // Bắt thêm nút Mua Ngay
  
  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get('id');

  function handleDetailPurchase(e, isBuyNow) {
      e.preventDefault();

      if (!checkLogin()) return; //Kiểm tra đăng nhập trước khi cho phép mua hàng

      const sizeSelect = productLayout.querySelector('.size-selector');
      const colorSelect = productLayout.querySelector('.color-selector');
      const qtyInput = productLayout.querySelector('.quantity-selector');
      const size = sizeSelect ? sizeSelect.value : "";
      const color = colorSelect ? colorSelect.value : "";
      const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

      if((sizeSelect && size === "") || (colorSelect && color === "")) {
          return alert("Vui lòng chọn đầy đủ Kích thước và Màu sắc!");
      }

      if (quantity < 1 || isNaN(quantity)) {
          return alert("Số lượng không hợp lệ!");
      }
      pushItemToCart(productId, size, color, quantity, isBuyNow);
  }

  if(btnAddCartDetail) btnAddCartDetail.onclick = (e) => handleDetailPurchase(e, false);
  if(btnBuyNowDetail) btnBuyNowDetail.onclick = (e) => handleDetailPurchase(e, true);
}

// Cập nhật giao diện giỏ hàng khi trang vừa tải xong
updateCartUI();