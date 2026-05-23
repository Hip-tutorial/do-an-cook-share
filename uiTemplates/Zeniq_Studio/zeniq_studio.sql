-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 07:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zeniq_studio`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Chờ xử lý'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(20) NOT NULL,
  `color` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `thumb2` varchar(255) DEFAULT NULL,
  `thumb3` varchar(255) DEFAULT NULL,
  `thumb4` varchar(255) DEFAULT NULL,
  `price_current` int(11) DEFAULT NULL,
  `price_original` int(11) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `stock_count` int(11) DEFAULT NULL,
  `color_text_short` varchar(255) DEFAULT NULL,
  `sizes_list` varchar(255) DEFAULT NULL,
  `colors_list` text DEFAULT NULL,
  `size_guide_html` text DEFAULT NULL,
  `desc_intro` text DEFAULT NULL,
  `desc_features` text DEFAULT NULL,
  `desc_care` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `main_image`, `thumb1`, `thumb2`, `thumb3`, `thumb4`, `price_current`, `price_original`, `discount`, `stock_count`, `color_text_short`, `sizes_list`, `colors_list`, `size_guide_html`, `desc_intro`, `desc_features`, `desc_care`) VALUES
(1, 'ATT', 'Áo Thun Trơn', 'Media/Tshirt/Tshirt.jpg', 'Media/Tshirt/white_shirt.jpg', 'Media/Tshirt/black_shirt.jpg', 'Media/Tshirt/gray_shirt.jpg', 'Media/Tshirt/blue_shirt.jpg', 299000, 499000, '-40%', 42, 'Màu: White Black Gray Blue', 'S,M,L,XL', 'white:Trắng (White), black:Đen (Black), gray:Xám (Gray), navy:Navy Blue', '<thead><tr><th>Size</th><th>Chiều dài (cm)</th><th>Chiều rộng (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>S</td><td>67</td><td>48</td><td>Dưới 1m60, nặng dưới 55kg</td></tr><tr><td>M</td><td>70</td><td>52</td><td>1m60 - 1m70, nặng 55-70kg</td></tr><tr><td>L</td><td>73</td><td>56</td><td>1m70 - 1m80, nặng 70-85kg</td></tr><tr><td>XL</td><td>76</td><td>60</td><td>Trên 1m80, nặng trên 85kg</td></tr></tbody>', 'Áo thun trơn được thiết kế với phong cách tối giản, cá tính và mạnh mẽ. Sản phẩm được làm từ chất liệu cao cấp, form dáng chuẩn mực dành riêng cho bạn.', '<li>Chất liệu 100% cotton, mềm mại và thoáng khí</li><li>Form dáng chuẩn, không bị co rút sau giặt</li><li>Màu sắc bền, không phai sau nhiều lần giặt</li><li>Thích hợp mặc hàng ngày</li>', '<li>Giặt với nước lạnh, không nên giặt với nước nóng</li><li>Không nên tẩy, sử dụng chất tẩy mạnh</li><li>Phơi nơi thoáng mát, tránh ánh nắng trực tiếp</li><li>Ủi ở nhiệt độ vừa phải</li>'),
(2, 'ASM', 'Áo Sơ Mi Trắng', 'Media/Shirt/Shirt.jpg', 'Media/Shirt/Shirt.jpg', 'Media/Shirt/Cream.jpg', 'Media/Shirt/beige.jpg', 'Media/Shirt/White.jpg', 399000, 599000, '-33%', 31, 'Màu: White Cream Beige', 'S,M,L,XL', 'white:Trắng (White), cream:Kem (Cream), beige:Beige', '<thead><tr><th>Size</th><th>Chiều dài (cm)</th><th>Chiều rộng (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>S</td><td>65</td><td>46</td><td>Dưới 1m60, nặng dưới 55kg</td></tr><tr><td>M</td><td>68</td><td>50</td><td>1m60 - 1m70, nặng 55-70kg</td></tr><tr><td>L</td><td>71</td><td>54</td><td>1m70 - 1m80, nặng 70-85kg</td></tr><tr><td>XL</td><td>74</td><td>58</td><td>Trên 1m80, nặng trên 85kg</td></tr></tbody>', 'Áo sơ mi trắng cổ điển được thiết kế với phong cách thanh lịch, sang trọng. Sản phẩm được làm từ chất liệu cotton cao cấp, thích hợp cho các dịp công sở hay dạo phố.', '<li>Chất liệu 100% cotton, mềm mại và thoáng khí</li><li>Kiểu dáng cổ điển, phù hợp với nhiều phong cách</li><li>Cúc bọc vải, tạo vẻ sang trọng</li><li>Thích hợp mặc công sở, dạo phố</li>', '<li>Giặt với nước lạnh</li><li>Không sử dụng chất tẩy mạnh</li><li>Phơi nơi thoáng mát</li><li>Ủi ở nhiệt độ vừa phải</li>'),
(3, 'QJN', 'Quần Jean Nam', 'Media/Jean/Jean.png', 'Media/Jean/Jean.png', 'Media/Jean/Dark.jpg', 'Media/Jean/Light.jpg', 'Media/Jean/Black.jpg', 549000, 799000, '-31%', 58, 'Màu: Blue Black', '28,30,32,34', 'dark-blue:Xanh Đậm, light-blue:Xanh Nhạt, black:Đen', '<thead><tr><th>Size</th><th>Chiều dài (cm)</th><th>Chiều rộng (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>28</td><td>95</td><td>38</td><td>Dưới 1m60, nặng dưới 60kg</td></tr><tr><td>30</td><td>98</td><td>42</td><td>1m60 - 1m70, nặng 60-75kg</td></tr><tr><td>32</td><td>101</td><td>46</td><td>1m70 - 1m80, nặng 75-90kg</td></tr><tr><td>34</td><td>104</td><td>50</td><td>Trên 1m80, nặng trên 90kg</td></tr></tbody>', 'Quần jean nam được thiết kế với phong cách hiện đại, thoải mái và bền bỉ. Sản phẩm được làm từ chất liệu denim cao cấp, thích hợp cho mọi hoàn cảnh.', '<li>Chất liệu 100% cotton denim, bền và thoáng khí</li><li>Form dáng chuẩn, không bị co rút sau giặt</li><li>Có túi thiết kế tiện lợi</li>', '<li>Giặt với nước lạnh</li><li>Phơi nơi thoáng mát, tránh ánh nắng trực tiếp</li>'),
(4, 'AKN', 'Áo Khoác Ngoài', 'Media/Jacket/Jacket.jpg', 'Media/Jacket/black jacket.jpg', 'Media/Jacket/navy blue jacket.jpg', 'Media/Jacket/gray jacket.jpg', 'Media/Jacket/brown jacket.jpg', 699000, 999000, '-30%', 24, 'Màu: Black Blue Gray', 'S,M,L,XL', 'black:Đen, navy:Navy Blue, gray:Xám, brown:Nâu', '<thead><tr><th>Size</th><th>Chiều dài (cm)</th><th>Chiều rộng (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>S</td><td>60</td><td>50</td><td>Dưới 1m60, nặng dưới 55kg</td></tr><tr><td>M</td><td>63</td><td>54</td><td>1m60 - 1m70, nặng 55-70kg</td></tr><tr><td>L</td><td>66</td><td>58</td><td>1m70 - 1m80, nặng 70-85kg</td></tr><tr><td>XL</td><td>69</td><td>62</td><td>Trên 1m80, nặng trên 85kg</td></tr></tbody>', 'Áo khoác ngoài được thiết kế với phong cách hiện đại, ấm áp và bền bỉ. Sản phẩm được làm từ chất liệu cao cấp, thích hợp cho mọi mùa.', '<li>Chất liệu cao cấp, ấm áp và thoáng khí</li><li>Có túi thiết kế tiện lợi</li><li>Khóa kéo chất lượng cao, bền bỉ</li>', '<li>Giặt với nước lạnh</li><li>Không dùng chất tẩy mạnh</li>'),
(5, 'GSN', 'Giày Sneaker', 'Media/Sneaker/Main.png', 'Media/Sneaker/white.png', 'Media/Sneaker/black.png', 'Media/Sneaker/gray.png', 'Media/Sneaker/blue.png', 449000, 699000, '-36%', 41, 'Màu: White Black Gray Blue', '36,37,38,39,40', 'white:Trắng, black:Đen, gray:Xám, blue:Xanh', '<thead><tr><th>Size</th><th>Chiều dài (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>36</td><td>22.5</td><td>Nữ dưới 1m60</td></tr><tr><td>37</td><td>23.5</td><td>Nữ 1m60 - 1m70</td></tr><tr><td>38</td><td>24.5</td><td>Nam dưới 1m70</td></tr><tr><td>39</td><td>25</td><td>Nam 1m70 - 1m80</td></tr><tr><td>40</td><td>25.5</td><td>Nam trên 1m80</td></tr></tbody>', 'Giày sneaker được thiết kế với phong cách hiện đại, thoải mái và bền bỉ. Chất liệu cao cấp, thích hợp cho mọi hoàn cảnh.', '<li>Đế cao su chống trượt, an toàn</li><li>Form dáng chuẩn, thoải mái khi mang</li><li>Thiết kế đơn giản nhưng sang trọng</li>', '<li>Vệ sinh bằng nước ấm và xà phòng nhẹ</li><li>Không nên ngâm nước lâu</li><li>Lau khô bằng khăn mềm sau khi giặt</li>'),
(6, 'MSB', 'Mũ Snapback', 'Media/Cap, watch/Cap/Main.png', 'Media/Cap, watch/Cap/Mix cap.avif', 'Media/Cap, watch/Cap/Black cap.jpg', 'Media/Cap, watch/Cap/White cap.jpg', 'Media/Cap, watch/Cap/Blue cap.jpg', 149000, 249000, '-40%', 67, 'Màu: Black White Red', 'one-size', 'black:Đen, white:Trắng, navy:Xanh Navy', '<thead><tr><th>Size</th><th>Chu vi đầu (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>One Size</td><td>54 - 58</td><td>Phù hợp với hầu hết mọi người</td></tr></tbody>', 'Mũ snapback được thiết kế với phong cách trẻ trung, năng động. Sản phẩm dễ dàng kết hợp với nhiều loại trang phục đường phố.', '<li>Chất liệu cotton cao cấp, mềm mại</li><li>Thiết kế snapback, dễ điều chỉnh kích cỡ</li><li>Form dáng chuẩn</li>', '<li>Giặt tay bằng nước lạnh</li><li>Không vắt mạnh, lau khô bằng khăn mềm</li><li>Để khô tự nhiên</li>'),
(7, 'TUX', 'Túi Xách', 'Media/Cap, watch/Hand bag/Main.png', 'Media/Cap, watch/Hand bag/Black.webp', 'Media/Cap, watch/Hand bag/Blue.png', 'Media/Cap, watch/Hand bag/White.webp', 'Media/Cap, watch/Hand bag/Beige.png', 599000, 899000, '-33%', 19, 'Màu: Black Brown', 'one-size', 'black:Đen, blue:Xanh, white:Trắng, beige:Beige', '', 'Túi xách được thiết kế với phong cách thanh lịch, sang trọng. Sản phẩm được làm từ chất liệu cao cấp, thích hợp cho mọi hoàn cảnh.', '<li>Chất liệu cao cấp, bền bỉ và sang trọng</li><li>Có nhiều ngăn để sắp xếp đồ vật</li><li>Quai xách thoải mái, không bị đau tay</li>', '<li>Lau sạch bằng khăn mềm ẩm sau khi sử dụng</li><li>Tránh tiếp xúc với nước quá lâu</li><li>Bảo quản ở nơi thoáng mát, khô ráo</li>'),
(8, 'DHT', 'Đồng hồ Đeo tay', 'Media/Cap, watch/Watch/Main.jpg', 'Media/Cap, watch/Watch/2.webp', 'Media/Cap, watch/Watch/Silver_1.webp', 'Media/Cap, watch/Watch/Silver_2.webp', 'Media/Cap, watch/Watch/Gold.webp', 799000, 1299000, '-38%', 35, 'Màu: Silver Black', 'S,M,L', 'Silver:Bạc (Silver), silver_2:Bạc v2 (Silver 2), gold:Vàng (Gold)', '<thead><tr><th>Size</th><th>Chu vi tay (cm)</th><th>Khuyến cáo</th></tr></thead><tbody><tr><td>S</td><td>16 - 18</td><td>Nữ, người có tay nhỏ</td></tr><tr><td>M</td><td>18 - 20</td><td>Nam, nữ có tay trung bình</td></tr><tr><td>L</td><td>20 - 22</td><td>Nam có tay lớn</td></tr></tbody>', 'Đồng hồ tay được thiết kế với phong cách hiện đại, sang trọng. Khẳng định đẳng cấp người đeo.', '<li>Mặt kính sapphire chống xước</li><li>Dây đeo cao cấp</li><li>Chuyển động quartz chính xác</li>', '<li>Tránh va chạm mạnh</li><li>Lau sạch bằng khăn mềm</li><li>Bảo quản ở nơi thoáng mát</li>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Đào Đạt', 'dat04052006@gmail.com', '$2y$10$crVE4fRj4xQDvilS9CHSWesl7yffquxpE46SvoN78EH6P.iqXlMEG', '2026-04-28 10:33:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
