// 1. TÌM CÁC THÀNH PHẦN TRÊN GIAO DIỆN
const authModal = document.getElementById('auth-modal');
const btnLoginHeader = document.getElementById('btn-login');
const closeAuthModal = document.getElementById('close-modal');
const submitBtn = document.getElementById('submit-btn');
const toggleModeBtn = document.getElementById('toggle-mode-btn');
const modalTitle = document.getElementById('modal-title');

// Các ô input
const nameGroup = document.getElementById('name-group');
const fullnameInput = document.getElementById('fullname');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const forgotPwLink = document.getElementById('forgot-pw-link');

let isLoginMode = true; // Mặc định mở lên là form Đăng nhập

// 2. MỞ VÀ ĐÓNG HỘP THOẠI
if (btnLoginHeader) {
  btnLoginHeader.onclick = (e) => {
    e.preventDefault();
    authModal.style.display = 'block';
  };
}

if (closeAuthModal) {
  closeAuthModal.onclick = () => {
    authModal.style.display = 'none';
  };
}

// 3. NÚT CHUYỂN ĐỔI: ĐĂNG NHẬP <-> ĐĂNG KÝ
if (toggleModeBtn) {
  toggleModeBtn.onclick = function() {
    isLoginMode = !isLoginMode; // Đảo ngược trạng thái
    
    if (isLoginMode) {
      // Chuyển sang giao diện ĐĂNG NHẬP
      modalTitle.innerText = "ĐĂNG NHẬP";
      submitBtn.innerText = "ĐĂNG NHẬP";
      toggleModeBtn.innerText = "Chưa có tài khoản? Đăng ký ngay";
      nameGroup.style.display = "none"; // Ẩn ô Họ Tên
      forgotPwLink.style.display = "block"; // Hiện nút Quên mật khẩu
    } else {
      // Chuyển sang giao diện ĐĂNG KÝ
      modalTitle.innerText = "ĐĂNG KÝ TÀI KHOẢN";
      submitBtn.innerText = "ĐĂNG KÝ";
      toggleModeBtn.innerText = "Đã có tài khoản? Đăng nhập ngay";
      nameGroup.style.display = "block"; // Hiện ô Họ Tên
      forgotPwLink.style.display = "none"; // Ẩn nút Quên mật khẩu
    }
  };
}

// 4. GỬI DỮ LIỆU ĐI BẰNG FETCH
if (submitBtn) {
  submitBtn.onclick = function() {
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    let fullname = "";

    // Kiểm tra trống
    if (email === "" || password === "") {
      alert("Vui lòng nhập đầy đủ Email và Mật khẩu!");
      return;
    }

    if (!isLoginMode) {
      fullname = fullnameInput.value.trim();
      if (fullname === "") {
        alert("Vui lòng nhập Họ và tên để đăng ký!");
        return;
      }
    }

    // Đóng gói dữ liệu
    let formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    if (!isLoginMode) formData.append('fullname', fullname);

    
    const currentUrl = window.location.pathname.toLowerCase();
    const basePath = currentUrl.includes('/product/') ? '../' : './';
    const targetFile = basePath + 'Config/' + (isLoginMode ? 'login_action.php' : 'register_action.php');

    fetch(targetFile, {
      method: 'POST',
      body: formData
    })
    .then(response => response.text()) 
    .then(data => {
      const result = data.trim();

      // Nếu PHP trả về chuỗi có dấu "|" (tức là đăng nhập/đăng ký thành công và có kèm tên)
      if (result.includes('|')) {
         const parts = result.split('|');
         const status = parts[0]; // Chứa chữ "success" hoặc "success_register"
         const realName = parts[1]; // Chứa Họ và tên thật

         // Lưu cả Email và Tên thật vào trình duyệt
         localStorage.setItem('currentUser', email);
         localStorage.setItem('currentUserName', realName);

         if (status === "success_register") {
            alert("Đăng ký thành công! Hệ thống tự động đăng nhập.");
         } else {
            alert("Đăng nhập thành công!");
         }
         
         location.reload(); // Tải lại trang
      } else {
         // Nếu không có dấu |, nghĩa là bị lỗi (Sai mật khẩu, Email đã tồn tại...)
         alert(result);
      }
    })
    .catch(error => {
      console.error('Lỗi:', error);
      alert("Có lỗi kết nối tới máy chủ PHP!");
    });
  };
}

// 5. XỬ LÝ NÚT THOÁT VÀ HIỂN THỊ HEADER
function updateHeaderUI() {
  const savedUser = localStorage.getItem('currentUser');
  const savedName = localStorage.getItem('currentUserName'); // Lấy tên thật từ bộ nhớ
  
  const userInfo = document.getElementById('user-info');
  const userName = document.getElementById('user-name');
  const btnLoginHeader = document.getElementById('btn-login');

  if (savedUser && userInfo && btnLoginHeader) {
    btnLoginHeader.style.display = 'none';
    userInfo.style.display = 'flex';
    
    // Ưu tiên hiển thị tên thật, nếu không có thì lấy phần đầu của Email làm dự phòng
    userName.innerText = "Chào, " + (savedName ? savedName : savedUser.split('@')[0]);
  }
}

// Chạy hiển thị ngay khi tải trang
updateHeaderUI();

// Xử lý nút Thoát
const btnLogout = document.getElementById('btn-logout');
if (btnLogout) {
  btnLogout.onclick = function(e) {
    e.preventDefault();
    localStorage.removeItem('currentUser');
    localStorage.removeItem('currentUserName'); // Thoát thì xóa luôn tên
    location.reload();
  };
}