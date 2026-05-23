// JS PHẦN ĐĂNG NHẬP / ĐĂNG KÝ VÀ TÌM KIẾM TRÊN TRANG CHỦ

  // --- 1. LẤY CÁC THÀNH PHẦN GIAO DIỆN ---
  const modal = document.getElementById('auth-modal');
  const btnLoginHeader = document.getElementById('btn-login'); // Nút trên thanh menu
  const btnClose = document.getElementById('close-modal');
  
  const title = document.getElementById('modal-title');
  const emailInput = document.getElementById('email');
  const pwInput = document.getElementById('password');
  const eyeIcon = document.getElementById('toggle-eye');
  const forgotPwLink = document.getElementById('forgot-pw-link');
  const submitBtn = document.getElementById('submit-btn');
  const toggleModeBtn = document.getElementById('toggle-mode-btn');
  
  const userInfo = document.getElementById('user-info');
  const userName = document.getElementById('user-name');
  const btnLogout = document.getElementById('btn-logout');

  let isLoginMode = true; // Biến ghi nhớ đang ở màn hình Đăng nhập hay Đăng ký

  // --- 2. CÁC HÀM ĐÓNG / MỞ CỬA SỔ ---
  btnLoginHeader.onclick = () => { modal.style.display = 'block'; }
  btnClose.onclick = () => { modal.style.display = 'none'; resetForm(); }

  // --- 3. CHỨC NĂNG ẨN/HIỆN MẬT KHẨU ---
  eyeIcon.onclick = function() {
    if (pwInput.type === "password") {
      pwInput.type = "text";
      eyeIcon.innerText = "🙈"; // Đổi icon
    } else {
      pwInput.type = "password";
      eyeIcon.innerText = "👁️";
    }
  };

  // --- 4. CHUYỂN ĐỔI GIỮA ĐĂNG NHẬP VÀ ĐĂNG KÝ ---
  toggleModeBtn.onclick = function() {
    isLoginMode = !isLoginMode; // Đảo ngược trạng thái
    resetForm(); // Xóa báo lỗi và dữ liệu cũ
    
    if (isLoginMode) {
      title.innerText = "ĐĂNG NHẬP";
      submitBtn.innerText = "ĐĂNG NHẬP";
      forgotPwLink.style.display = "block"; // Hiện Quên MK
      toggleModeBtn.innerText = "Chưa có tài khoản? Đăng ký ngay";
    } else {
      title.innerText = "ĐĂNG KÝ TÀI KHOẢN";
      submitBtn.innerText = "ĐĂNG KÝ";
      forgotPwLink.style.display = "none"; // Ẩn Quên MK
      toggleModeBtn.innerText = "Đã có tài khoản? Đăng nhập";
    }
  };

  // --- 5. HÀM KIỂM TRA LỖI (VALIDATION) ---
  function validateForm() {
    let isValid = true;
    const emailVal = emailInput.value.trim();
    const pwVal = pwInput.value.trim();

    // Reset viền đỏ trước khi kiểm tra
    emailInput.classList.remove('input-error');
    pwInput.classList.remove('input-error');

    // Kiểm tra định dạng Email bằng công thức (Regex) đơn giản
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailVal)) {
      emailInput.classList.add('input-error');
      isValid = false;
    }

    // Kiểm tra mật khẩu (ít nhất 6 ký tự)
    if (pwVal.length < 6) {
      pwInput.classList.add('input-error');
      isValid = false;
    }

    return isValid;
  }

  // --- 6. XỬ LÝ KHI BẤM NÚT ĐĂNG NHẬP / ĐĂNG KÝ ---
  submitBtn.onclick = function() {
    // Nếu là chế độ Đăng Ký, bắt buộc phải validate không lỗi
    if (!isLoginMode) {
      if (!validateForm()) {
        alert("Vui lòng nhập đúng Email và Mật khẩu (ít nhất 6 ký tự)!");
        return; // Dừng lại, không cho đăng ký
      }
      alert("Đăng ký thành công! Hệ thống sẽ tự động đăng nhập.");
    } 
    // Nếu là Đăng nhập, chỉ kiểm tra xem có nhập chưa
    else {
      if (emailInput.value === "" || pwInput.value === "") {
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
      }
      alert("Đăng nhập thành công!");
    }

    // Lưu thông tin User vào bộ nhớ tạm (local storage)
    localStorage.setItem('currentUser', emailInput.value);
    modal.style.display = 'none';
    updateUI();
  };

  // Xóa viền đỏ khi user bắt đầu gõ lại
  emailInput.oninput = () => emailInput.classList.remove('input-error');
  pwInput.oninput = () => pwInput.classList.remove('input-error');

  // Hàm dọn dẹp form
  function resetForm() {
    emailInput.value = "";
    pwInput.value = "";
    emailInput.classList.remove('input-error');
    pwInput.classList.remove('input-error');
    pwInput.type = "password";
    eyeIcon.innerText = "👁️";
  }

  // --- 7. ĐỒNG BỘ GIAO DIỆN XUYÊN TRANG ---
  function updateUI() {
    const savedUser = localStorage.getItem('currentUser');
    if (savedUser) {
      btnLoginHeader.style.display = 'none';
      userInfo.style.display = 'flex';
      userName.innerText = "Chào, " + savedUser.split('@')[0];
    } else {
      btnLoginHeader.style.display = 'block';
      userInfo.style.display = 'none';
    }
  }

  btnLogout.onclick = function() {
    localStorage.removeItem('currentUser');
    updateUI();
  };

  // Luôn chạy khi tải trang
  updateUI();


  /* JS TÌM KIẾM TRỰC TIẾP TRÊN TRANG CHỦ
     (Thông minh: Bỏ dấu + Đảo từ + Lọc Card) */
  
  // Hàm loại bỏ dấu tiếng Việt
  function removeAccents(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D');
  }

  // Dữ liệu dùng cho danh sách xổ xuống (Gợi ý)
  const productsData = [
    { name: "Áo Thun Trơn", url: "/Project/Offcial/Product/product.html" },
    { name: "Áo Sơ Mi Trắng", url: "/Project/Offcial/Product/product1.html" },
    { name: "Quần Jean nam", url: "/Project/Offcial/Product/product2.html" },
    { name: "Áo Khoác ngoài", url: "/Project/Offcial/Product/product3.html" },
    { name: "Giày Sneaker", url: "/Project/Offcial/Product/product4.html" },
    { name: "Mũ Snapback", url: "/Project/Offcial/Product/product5.html" },
    { name: "Túi Xách", url: "/Project/Offcial/Product/product6.html" },
    { name: "Đồng hồ Đeo tay", url: "/Project/Offcial/Product/product7.html" }
  ];

  const searchBar = document.getElementById("searchBar");
  const clearBtn = document.getElementById("clearBtn");
  const searchBtn = document.getElementById("searchBtn");
  const ul = document.getElementById("suggestion");
  
  const introTitle = document.getElementById("intro-title");
  const introDesc = document.getElementById("intro-desc");
  const allCards = document.querySelectorAll(".product-item");
  
  // Quản lý hiển thị nút X xóa nhanh
  searchBar.addEventListener("input", () => {
    if (searchBar.value.length > 0) clearBtn.style.display = "block";
    else { clearBtn.style.display = "none"; ul.style.display = "none"; }
  });

  clearBtn.addEventListener("click", () => {
    searchBar.value = "";
    clearBtn.style.display = "none";
    ul.style.display = "none";
    searchBar.focus(); 
  });

  // Chức năng 1: Gợi ý khi gõ
  searchBar.addEventListener("keyup", (event) => {
    if (event.key === "Enter") return; 

    const rawInput = searchBar.value.toLowerCase().trim();
    if (rawInput === "") { ul.style.display = "none"; return; }

    const cleanInput = removeAccents(rawInput);
    const searchWords = cleanInput.split(/\s+/); // Cắt từ để đảo chữ

    ul.style.display = "block";
    ul.innerHTML = "";

    const filteredProducts = productsData.filter((item) => {
      const productName = removeAccents(item.name.toLowerCase());
      // Phải chứa TẤT CẢ các từ vừa nhập
      return searchWords.every(word => productName.includes(word));
    });

    if (filteredProducts.length === 0) {
      const li = document.createElement("li");
      li.className = "no-result-item";
      li.innerHTML = "📦 Không tìm thấy sản phẩm phù hợp";
      ul.appendChild(li);
      return; 
    }

    const length = filteredProducts.length > 5 ? 5 : filteredProducts.length;
    for (let i = 0; i < length; i++) {
      const li = document.createElement("li");
      li.textContent = filteredProducts[i].name;
      li.setAttribute("data-url", filteredProducts[i].url); 
      ul.appendChild(li);
    }
  });

  // Chức năng 2: Bấm vào gợi ý -> Nhảy sang trang chi tiết
  ul.addEventListener("click", (event) => {
    if (event.target.tagName === "LI" && !event.target.classList.contains("no-result-item")) {
      const targetUrl = event.target.getAttribute("data-url");
      window.open(targetUrl, "_blank"); 
      ul.style.display = "none";
    }
  });

  // Chức năng 3: Bấm nút TÌM (hoặc ENTER) -> Ẩn/Hiện Card trực tiếp trên trang chủ
  function filterCardsOnPage() {
    const rawKeyword = searchBar.value.trim();
    ul.style.display = "none"; // Ẩn cái bảng gợi ý đi

    // Nếu gõ khoảng trắng hoặc xóa hết chữ rồi bấm Tìm
    if (rawKeyword === "") {
      allCards.forEach(card => card.classList.remove("hide-item")); // Hiện lại toàn bộ
      introTitle.innerText = "[Slogan]";
      introDesc.innerText = "[Description] Cửa hàng mang đến phong cách tối giản, cá tính và mạnh mẽ. Chất liệu cao cấp, form dáng chuẩn mực dành riêng cho bạn.";
      return;
    }

    const cleanKeyword = removeAccents(rawKeyword.toLowerCase());
    const searchWords = cleanKeyword.split(/\s+/); // Tách từ khóa thành mảng
    let foundCount = 0;

    // Lướt qua từng cái Card ở trang chủ
    allCards.forEach(card => {
      // Lấy tên thẻ Card và bỏ dấu tiếng Việt đi
      const productName = removeAccents(card.querySelector(".card-title").innerText.toLowerCase());

      // Kiểm tra xem mọi từ trong ô tìm kiếm có nằm trong tên Card không
      const isMatch = searchWords.every(word => productName.includes(word));

      if (isMatch) {
        card.classList.remove("hide-item"); // Chứa đủ từ -> Hiện
        foundCount++;
      } else {
        card.classList.add("hide-item"); // Thiếu từ -> Ẩn
      }
    });

    // Cập nhật Slogan để thông báo kết quả
    if (foundCount > 0) {
      introTitle.innerText = `Kết quả tìm kiếm cho: "${rawKeyword}"`;
      introDesc.innerText = `Tìm thấy ${foundCount} sản phẩm phù hợp.`;
    } else {
      introTitle.innerText = `Không tìm thấy: "${rawKeyword}"`;
      introDesc.innerText = `Rất tiếc, shop chưa có sản phẩm nào khớp với tìm kiếm của bạn.`;
    }
    
    // Cuộn màn hình nhẹ nhàng xuống khu vực hiển thị sản phẩm
    document.getElementById("page-intro").scrollIntoView({ behavior: 'smooth' });
  }

  // Lắng nghe sự kiện Bấm nút Tìm & Enter
  searchBtn.addEventListener("click", filterCardsOnPage);
  searchBar.addEventListener("keypress", (event) => {
    if (event.key === "Enter") { 
      event.preventDefault(); 
      filterCardsOnPage(); 
    }
  });

  // Click ra ngoài thì ẩn menu gợi ý
  document.addEventListener("click", function(event) {
    if (!searchBar.contains(event.target) && !clearBtn.contains(event.target) && !ul.contains(event.target)) {
      ul.style.display = "none";
    }
  });