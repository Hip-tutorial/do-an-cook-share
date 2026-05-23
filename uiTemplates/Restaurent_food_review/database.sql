
CREATE DATABASE IF NOT EXISTS food_review;
USE food_review;

CREATE TABLE users(
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100),
email VARCHAR(100),
password VARCHAR(255),
role VARCHAR(20)
);

CREATE TABLE restaurants(
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255),
address TEXT,
description TEXT,
image TEXT,
rating FLOAT
);

CREATE TABLE reviews(
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
restaurant_id INT,
rating INT,
content TEXT,
created_at DATETIME
);

INSERT INTO restaurants(name,address,description,image,rating) VALUES
('Pizza 4P''s','TP.HCM','Pizza phong cách Nhật nổi tiếng tại Việt Nam','assets/images/pizza.jpg',4.8),
('Gogi House','Hà Nội','Nhà hàng thịt nướng Hàn Quốc','assets/images/gogi.jpg',4.6),
('Kichi Kichi','Đà Nẵng','Lẩu băng chuyền nổi tiếng','assets/images/kichi.jpg',4.5),
('Phở Thìn','Hà Nội','Quán phở nổi tiếng lâu năm','assets/images/pho.jpg',4.7),
('Highlands Coffee','Toàn quốc','Chuỗi cafe nổi tiếng Việt Nam','assets/images/coffee.jpg',4.4),
('Manwah','Hải Phòng','Lẩu Đài Loan cao cấp','assets/images/manwah.jpg',4.7);
