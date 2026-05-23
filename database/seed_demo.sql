SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE comments;
TRUNCATE TABLE recipes;
TRUNCATE TABLE users;

INSERT INTO users (id, fullname, email, username, password) VALUES
(1, 'Nguyễn Mai An', 'maian@cookshare.local', 'maian', '$2y$12$TCF5nqZ/HbeC5gF.9LjcSeWWdrwoPUg2//RHD3JE00fWf1l/ZOa1u'),
(2, 'Trần Nam Bếp', 'nambep@cookshare.local', 'nambep', '$2y$12$l3dYWnz91x9jjrLfU0C4pe26im01v8DQsk344wfszbbkbwQyoMAEK');

INSERT INTO recipes (id, user_id, title, image, description, ingredients, steps, created_at) VALUES
(1, 1, 'Pizza phô mai kéo sợi', 'seed/pizza.jpg',
'Đế bánh mỏng giòn, sốt cà chua thơm và lớp phô mai vàng ruộm hợp cho bữa tối cuối tuần.',
'Đế pizza 1 cái\nSốt cà chua 4 muỗng canh\nPhô mai mozzarella 180g\nXúc xích 80g\nỚt chuông 1/2 quả\nLá oregano 1 muỗng cà phê',
'1. Làm nóng lò ở 220 độ C trong 10 phút.\n2. Phết sốt cà chua lên đế bánh, rải xúc xích và ớt chuông.\n3. Phủ phô mai mozzarella, rắc oregano.\n4. Nướng 12-15 phút đến khi viền bánh giòn và phô mai tan chảy.',
'2026-05-01 08:15:00'),
(2, 1, 'Phở bò tái thơm gừng', 'seed/pho.jpg',
'Tô phở nóng với nước dùng trong, vị ngọt xương và hương quế hồi nhẹ nhàng.',
'Xương bò 1kg\nBánh phở 600g\nThịt bò tái 300g\nGừng 1 củ\nHành tây 1 củ\nQuế, hồi, thảo quả\nHành lá, rau thơm',
'1. Nướng gừng và hành tây cho thơm.\n2. Hầm xương bò với gia vị trong 2-3 giờ, hớt bọt thường xuyên.\n3. Nêm muối, nước mắm và chút đường phèn.\n4. Chần bánh phở, xếp thịt bò tái rồi chan nước dùng thật nóng.',
'2026-05-02 09:20:00'),
(3, 1, 'Lẩu nấm chua cay', 'seed/kichi.jpg',
'Nồi lẩu thanh vị, nhiều nấm và rau xanh, hợp ăn cùng gia đình trong ngày mưa.',
'Nước dùng gà 1.5 lít\nNấm kim châm 150g\nNấm đùi gà 150g\nCải thảo 300g\nĐậu hũ 2 bìa\nSa tế 2 muỗng canh\nSả, cà chua, me chua',
'1. Phi thơm sả và cà chua với sa tế.\n2. Cho nước dùng vào nấu sôi, nêm me chua, muối và đường.\n3. Thêm đậu hũ, nấm và rau theo từng lượt.\n4. Ăn nóng cùng bún hoặc mì trứng.',
'2026-05-03 10:05:00'),
(4, 1, 'Cà phê sữa đá kem muối', 'seed/coffee.jpg',
'Ly cà phê đậm, sữa đặc ngọt vừa và lớp kem muối béo nhẹ để tỉnh táo đầu ngày.',
'Cà phê phin 30g\nSữa đặc 30ml\nSữa tươi 60ml\nWhipping cream 80ml\nMuối 1/4 muỗng cà phê\nĐá viên',
'1. Pha cà phê phin thật đậm.\n2. Đánh whipping cream với sữa tươi và muối đến khi sánh nhẹ.\n3. Khuấy cà phê với sữa đặc, thêm đá.\n4. Rót kem muối lên trên và dùng ngay.',
'2026-05-04 07:45:00'),
(5, 1, 'Bữa tiệc gia đình cuối tuần', 'seed/anhnhahang.jpg',
'Gợi ý mâm món dễ chuẩn bị với món chính, rau ăn kèm và đồ uống cho buổi gặp mặt nhỏ.',
'Gà nướng 1 con\nSalad rau củ 1 tô\nBánh mì hoặc cơm nóng\nTrái cây theo mùa\nNước sốt chấm\nĐồ uống yêu thích',
'1. Chuẩn bị món chính trước giờ ăn khoảng 90 phút.\n2. Làm salad và nước chấm trong lúc chờ món chính chín.\n3. Bày món theo nhóm nóng, nguội, rau và đồ uống.\n4. Giữ món nóng bằng giấy bạc đến khi dùng.',
'2026-05-05 18:10:00'),
(6, 2, 'Bò nướng kiểu Hàn tại nhà', 'seed/gogi.jpg',
'Thịt bò mềm ướp lê, tỏi, nước tương và dầu mè, nướng nhanh trên chảo gang.',
'Thịt ba chỉ bò 500g\nLê 1/2 quả\nTỏi băm 1 muỗng canh\nNước tương 3 muỗng canh\nDầu mè 1 muỗng canh\nĐường nâu 1 muỗng canh\nXà lách, kim chi',
'1. Xay lê rồi trộn cùng nước tương, tỏi, dầu mè và đường.\n2. Ướp thịt bò 30-45 phút.\n3. Làm nóng chảo gang, nướng thịt từng lớp mỏng.\n4. Cuốn thịt với xà lách, kim chi và dùng nóng.',
'2026-05-06 19:00:00'),
(7, 2, 'Lẩu Đài Loan cay nhẹ', 'seed/manwah.jpg',
'Nước lẩu thơm thảo mộc, cay vừa, dùng cùng thịt bò lát mỏng và nhiều loại viên thả lẩu.',
'Nước dùng xương 1.5 lít\nGói gia vị lẩu Đài Loan\nThịt bò lát 300g\nViên thả lẩu 250g\nBắp Mỹ 1 trái\nRau cải, nấm, đậu hũ',
'1. Đun sôi nước dùng với gói gia vị, bắp Mỹ và đậu hũ.\n2. Nêm lại bằng nước tương hoặc muối theo khẩu vị.\n3. Thả viên lẩu, nấm và rau vào trước.\n4. Nhúng thịt bò từng lát để giữ độ mềm.',
'2026-05-07 18:30:00'),
(8, 2, 'Mì Ý sốt bò bằm', 'seed/pizza.jpg',
'Sốt bò bằm cà chua đậm vị, dễ làm và hợp với cả bữa trưa lẫn bữa tối nhanh.',
'Mì spaghetti 250g\nThịt bò bằm 250g\nCà chua hộp 300g\nHành tây 1/2 củ\nTỏi băm 1 muỗng cà phê\nBơ lạt 15g\nPhô mai bào',
'1. Luộc mì với nước sôi có muối đến khi vừa chín.\n2. Phi thơm tỏi, hành tây rồi xào thịt bò bằm.\n3. Cho cà chua vào nấu sệt 12-15 phút.\n4. Trộn mì với sốt, thêm bơ và phô mai bào.',
'2026-05-08 12:00:00'),
(9, 2, 'Phở cuốn thịt bò', 'seed/pho.jpg',
'Bánh phở mềm cuốn thịt bò xào, rau thơm và chấm nước mắm chua ngọt.',
'Bánh phở cuốn 500g\nThịt bò 250g\nXà lách 1 cây\nRau mùi, húng quế\nTỏi băm\nNước mắm, chanh, đường, ớt',
'1. Xào thịt bò nhanh với tỏi, nước mắm và tiêu.\n2. Trải bánh phở, xếp rau và thịt bò vào giữa.\n3. Cuốn chắc tay để không bung nhân.\n4. Pha nước chấm chua ngọt và dùng ngay.',
'2026-05-09 11:25:00'),
(10, 2, 'Gà áp chảo sốt cam', 'seed/kichi.jpg',
'Ức gà áp chảo vàng mặt, áo sốt cam chua ngọt và ăn kèm rau củ luộc.',
'Ức gà 2 miếng\nCam tươi 2 quả\nMật ong 1 muỗng canh\nBơ lạt 15g\nTỏi băm 1 muỗng cà phê\nMuối, tiêu\nBông cải, cà rốt',
'1. Ướp gà với muối và tiêu 15 phút.\n2. Áp chảo gà đến khi hai mặt vàng và chín bên trong.\n3. Nấu nước cam với mật ong, bơ và tỏi đến khi hơi sệt.\n4. Áo sốt lên gà, ăn kèm rau củ luộc.',
'2026-05-10 17:40:00');

INSERT INTO comments (id, recipe_id, user_id, content, created_at) VALUES
(1, 1, 2, 'Công thức pizza dễ theo, phần nướng 15 phút rất vừa với lò nhà mình.', '2026-05-11 08:10:00'),
(2, 1, 1, 'Bạn có thể thêm nấm mỡ hoặc hành tây nếu thích vị ngọt hơn.', '2026-05-11 08:35:00'),
(3, 2, 2, 'Nước dùng phở trong và thơm. Mình sẽ thử nướng gừng kỹ hơn lần sau.', '2026-05-11 09:05:00'),
(4, 3, 2, 'Lẩu chua cay ăn với mì trứng rất hợp, vị không bị gắt.', '2026-05-11 10:20:00'),
(5, 4, 2, 'Kem muối béo nhẹ, công thức này hợp để demo đồ uống.', '2026-05-11 13:15:00'),
(6, 5, 2, 'Ý tưởng bày mâm cuối tuần khá đẹp, có thể chuẩn bị trước nhiều món.', '2026-05-11 18:45:00'),
(7, 6, 1, 'Ướp lê làm thịt mềm rõ rệt, nướng nhanh nên không bị khô.', '2026-05-12 08:30:00'),
(8, 6, 2, 'Nếu có thời gian, ướp qua đêm trong ngăn mát sẽ đậm vị hơn.', '2026-05-12 08:50:00'),
(9, 7, 1, 'Nước lẩu cay nhẹ rất dễ ăn, phù hợp cả người không ăn cay nhiều.', '2026-05-12 11:10:00'),
(10, 8, 1, 'Mì Ý sốt bò bằm đơn giản nhưng trình bày lên ảnh rất đẹp.', '2026-05-12 12:30:00'),
(11, 9, 1, 'Phở cuốn nên dùng bánh phở mới để cuốn không bị rách.', '2026-05-12 15:40:00'),
(12, 10, 1, 'Sốt cam cân bằng vị béo của gà, ăn cùng bông cải rất hợp.', '2026-05-12 19:20:00');

ALTER TABLE users AUTO_INCREMENT = 3;
ALTER TABLE recipes AUTO_INCREMENT = 11;
ALTER TABLE comments AUTO_INCREMENT = 13;

SET FOREIGN_KEY_CHECKS = 1;
