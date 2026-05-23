// Những phần đã chỉnh sửa 1. Từ 11 đến 52 / 2. Từ 105 đến 117 / 3. Từ 119 đến 169 / 4. Từ 186 đến 196 (Thêm tự động lọc từ khóa)

  /* JS TÌM KIẾM TRỰC TIẾP TRÊN TRANG CHỦ
     (Thông minh: Bỏ dấu + Đảo từ + Lọc Card) */
  
  // Hàm loại bỏ dấu tiếng Việt
  function removeAccents(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D');
  }

  // // Dữ liệu dùng cho danh sách xổ xuống (Gợi ý)
  // const productsData = [
  //   { name: "Áo Thun Trơn", url: "/Project/Offcial/Product/product.html" },
  //   { name: "Áo Sơ Mi Trắng", url: "/Project/Offcial/Product/product1.html" },
  //   { name: "Quần Jean nam", url: "/Project/Offcial/Product/product2.html" },
  //   { name: "Áo Khoác ngoài", url: "/Project/Offcial/Product/product3.html" },
  //   { name: "Giày Sneaker", url: "/Project/Offcial/Product/product4.html" },
  //   { name: "Mũ Snapback", url: "/Project/Offcial/Product/product5.html" },
  //   { name: "Túi Xách", url: "/Project/Offcial/Product/product6.html" },
  //   { name: "Đồng hồ Đeo tay", url: "/Project/Offcial/Product/product7.html" }
  // ];

  // Dữ liệu dùng cho danh sách xổ xuống (Tự động quét từ màn hình thay vì gõ tay)
  const searchBar = document.getElementById("searchBar");
  const clearBtn = document.getElementById("clearBtn");
  const searchBtn = document.getElementById("searchBtn");
  const ul = document.getElementById("suggestion");
  
  const introTitle = document.getElementById("intro-title");
  const introDesc = document.getElementById("intro-desc");
  const allCards = document.querySelectorAll(".product-item");

  const productsData = []; 
  
  // Đồng bộ dữ liệu tìm kiếm sử dụng LocalStorage
  if (allCards.length > 0) {
    allCards.forEach(card => {
      const titleLink = card.querySelector(".card-title");
      if (titleLink) {
        productsData.push({
          name: titleLink.innerText.trim(),
          url: titleLink.getAttribute("href") 
        });
      }
    });
    // Lưu dữ liệu quét được vào bộ nhớ tạm
    localStorage.setItem('globalProductsData', JSON.stringify(productsData));
  } else {
    // Nếu ở trang sản phẩm (không có Card), mượn dữ liệu từ bộ nhớ tạm
    const savedData = localStorage.getItem('globalProductsData');
    if (savedData) productsData.push(...JSON.parse(savedData));
  }
  
  
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

  //  Gợi ý khi gõ
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
      let targetUrl = event.target.getAttribute("data-url"); 
      
      // Tự động thêm "../" nếu đang đứng bên trong thư mục Product
      if (window.location.pathname.toLowerCase().includes('/product/')) {
          targetUrl = "../" + targetUrl; 
      }
      
      window.location.href = targetUrl; 
      ul.style.display = "none";
    }
  });

  // Chức năng 3: Lọc Card và Chuyển đổi trang dựa trên keywword sản phẩm 
  function filterCardsOnPage() {
    const rawKeyword = searchBar.value.trim();
    ul.style.display = "none"; 

    // TRƯỜNG HỢP 1: ĐANG Ở TRANG SẢN PHẨM -> Đẩy từ khóa về URL của trang chủ
    if (allCards.length === 0) {
      if (rawKeyword !== "") {
          window.location.href = `../index.php?search=${encodeURIComponent(rawKeyword)}`;
      } else {
          window.location.href = `../index.php`;
      }
      return;
    }

    // TRƯỜNG HỢP 2: ĐANG Ở TRANG CHỦ -> Thực hiện lọc trực tiếp trên lưới sản phẩm
    if (rawKeyword === "") {
      allCards.forEach(card => card.classList.remove("hide-item")); 
      if(introTitle) introTitle.innerText = " TỐI GIẢN TẠO NÊN SỰ KHÁC BIỆT";
      if(introDesc) introDesc.innerText = "Zeniq Studio mang đến phong cách tối giản, cá tính và mạnh mẽ. Chất liệu vải cao cấp, form dáng chuẩn mực dành riêng cho bạn mỗi ngày.";
      return;
    }

    const cleanKeyword = removeAccents(rawKeyword.toLowerCase());
    const searchWords = cleanKeyword.split(/\s+/); 
    let foundCount = 0;

    allCards.forEach(card => {
      const productName = removeAccents(card.querySelector(".card-title").innerText.toLowerCase());
      const isMatch = searchWords.every(word => productName.includes(word));

      if (isMatch) {
        card.classList.remove("hide-item"); 
        foundCount++;
      } else {
        card.classList.add("hide-item"); 
      }
    });

    if (foundCount > 0) {
      if(introTitle) introTitle.innerText = `Kết quả tìm kiếm cho: "${rawKeyword}"`;
      if(introDesc) introDesc.innerText = `Tìm thấy ${foundCount} sản phẩm phù hợp.`;
    } else {
      if(introTitle) introTitle.innerText = `Không tìm thấy: "${rawKeyword}"`;
      if(introDesc) introDesc.innerText = `Rất tiếc, shop chưa có sản phẩm nào khớp với tìm kiếm của bạn.`;
    }
    
    const pageIntro = document.getElementById("page-intro");
    if(pageIntro) pageIntro.scrollIntoView({ behavior: 'smooth' });
  }

  // Kích hoạt bộ lọc sản phẩm hoặc điều hướng trang khi tìm kiếm sản phẩm ( Enter or ấn tìm kiếm)
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

   // Chưc năng 4: Tự động lọc từ khóa từ URL  (Khi vừa chuyển từ trang sản phẩm về)
  window.addEventListener('DOMContentLoaded', () => {
    if (allCards.length > 0) {
      const urlParams = new URLSearchParams(window.location.search);
      const searchKeyword = urlParams.get('search');
      if (searchKeyword) {
        searchBar.value = searchKeyword;
        filterCardsOnPage(); 
      }
    }
  });