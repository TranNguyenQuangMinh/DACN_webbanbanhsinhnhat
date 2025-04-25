-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 03:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `delivery_time` datetime NOT NULL,
  `delivery_address` text NOT NULL,
  `message` text DEFAULT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`) VALUES
(1, 'Mini cake (Orange & Strawberry)', 'Bánh gato sinh nhật size mini (10cm) được decor bằng cam khô và dâu tây trên bề mặt, cốt gato vanilla mix hoa quả rất phù hợp cho các bé trên 3 tuổi. Bánh được làm handmade dưới bàn tay của các người thợ tại Pmoments', 170000, 'https://pmoments.vn/public/upload/images/products/2023-11-04/mHiipW6vk4OvP9tnnUCVTrU2yrO4vdfjbDyqGEMB.jpeg', '2025-04-18 13:41:30'),
(2, 'Mini cake 2 (Cheese fruits)', 'Bánh gato sinh nhật size mini (10cm) được decor bằng một lớp phủ kem cheese và hoa quả tươi theo mùa, cốt gato vanilla mix hoa quả rất phù hợp cho các bé trên 3 tuổi. Bánh được làm handmade dưới bàn tay của các người thợ tại Pmoments', 170000, 'https://pmoments.vn/public/upload/images/products/2023-11-04/N7oEAieQvB3jtA5lrNu6Qz6pNLMBipUl6brgA0ro.jpeg', '2025-04-18 13:34:36'),
(3, 'Mini cake 3 (Fresh Lemon)', 'Bánh gato sinh nhật size mini (10cm) được decor bằng những lát chanh vàng trên bề mặt và hoa vẽ decor ở thân bánh, cốt gato vanilla mix hoa quả rất phù hợp cho các bé trên 3 tuổi. Bánh được làm handmade dưới bàn tay của các người thợ tại Pmoments', 190000, 'https://pmoments.vn/public/upload/images/products/2023-11-04/uJRTwSFtGyBTNa7Rr3meDIMed4TS9ask2MUCJ9u9.jpeg', '2025-04-18 13:33:15'),
(4, 'Letao', 'Phô mai Letao có xuất sứ từ Hokkaido ( Nhật Bản ). Chiếc bánh với lớp phô mai nướng chua nhẹ hòa quyện cùng lớp phô mai mousse thơm ngậy. Bánh được decor dừa khô và trái thanh trà tươi. \r\nSize: đường kính 16cm - cao 7cm', 500000, 'https://pmoments.vn/public/upload/images/products/2023-11-02/Bl4oZDGZdPYBWuy7y7tQUJMWl8SUGvO4W9ZfQnYE.jpeg', '2025-04-23 14:52:33'),
(5, 'Letao 2', 'Phô mai Letao có xuất sứ từ Hokkaido ( Nhật Bản ). Chiếc bánh với lớp phô mai nướng chua nhẹ hòa quyện cùng lớp phô mai mousse thơm ngậy. Bánh được  decor bằng chà bông, bánh oreo và trứng muối handmade.\r\nSize: đường kính 16cm - cao 7cm', 500000, 'https://pmoments.vn/public/upload/images/products/2023-11-01/S4f4w64FswWsLxoBufnxvaOcBjg36moZNykcYVvE.jpeg', '2025-04-23 15:04:54'),
(6, 'Red Velvet', 'Cốt bánh ẩm, mềm mượt như nhung, hơi chua dịu và thoang thoảng hương cacao. Lớp kem phomai mát lạnh, được đánh vừa độ để bông mềm mà vẫn ngậy béo.\r\nSize: đường kính 16cm - cao 7cm', 380000, 'https://pmoments.vn/public/upload/images/products/2023-11-02/H2I2NzKu2Ow9GM4BSgNDl5ybui6p60gljctxru1B.jpeg', '2025-04-23 15:06:25'),
(7, 'Passion Cheese Mousse', 'Passion Cheese Mousse tại P Moments không chỉ là một chiếc bánh thông thường, mà là sự hòa quyện hoàn hảo giữa vị chua thanh mát của chanh leo và vị béo ngậy của phô mai cao cấp. Với từng miếng bánh, bạn sẽ cảm nhận được sự cân bằng tinh tế giữa lớp mousse mịn màng và vị ngọt nhẹ, đủ để làm say mê bất kỳ ai có gu ẩm thực tinh tế.\r\nSize: đường kính 16cm - cao 7cm', 390000, 'https://pmoments.vn/public/upload/images/products/2023-11-02/dlj3nz4MqVpeUZrjBSVAdrb5ps0Db18J51KOKpDT.jpeg', '2025-04-23 15:08:28'),
(18, 'Bánh mì Ram Ram', 'Bánh mì! Ràm ràm!\" quái vật bánh mì trỗi dậy, \"hãy đầu hàng hoặc bị phết bơ\", dân chúng la hét, một ông chú run rẩy đưa tương ớt. Quái vật nếm thử, ho khéeeee !!Cay quá!!! Lăn lộn, rớt vào nồi phở. Thế là sáng nay có bánh mì chấm phở', 999999, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEVYFJPeFRM8d_uqY4xLZx_Q4EwDbnUUc0uw&s', '2025-04-24 14:56:14'),
(19, 'Capuchino Assassinno', 'Câu chuyện của Cappuccino Assassino bắt đầu tại ngôi làng yên bình Yggdrasil, nơi anh từng là một chàng trai trẻ mơ mộng, hy vọng trở thành một samurai cao quý. Giấc mơ đó đã tan vỡ khi Crocodilo Bombardino, một con cá sấu biết bay khát khao hủy diệt, san phẳng ngôi làng thành bình địa. Hầu như không ai sống sót — ngoại trừ cậu bé, Cappuccino', 666666, 'https://http2.mlstatic.com/D_NQ_NP_861825-MLC83945029805_042025-O.webp', '2025-04-24 15:05:57'),
(20, 'Tallia 5 vị', 'Bánh mousse 5 vị (tiramisu, matcha tiramisu, red velvet, chocolate, chanh leo) phù hợp cho bữa tiệc đông người nhưng mỗi người một khẩu vị khác nhau. Bánh mousse được làm từ nguyên liệu tươi và độ ngọt được điều chỉnh lại để phù hợp với xu hướng giảm ngọt hiện nay\r\nSize: đường kính 16cm - cao 7-8cm', 400000, 'https://file.hstatic.net/200000665395/file/content-ve-banh-ngot-4_4ce5d14fac104bf1ae8ac5ac00e285c9_grande.jpg', '2025-04-24 15:25:14'),
(21, 'Gato Cừu', 'Bánh gato cốt vanila được decor bánh tươi thành bé cừu dễ thương\r\nSize: đường kính 16cm - cao 9cm', 360000, 'https://attachment.momocdn.net/common/u/2e02fb5fe4f64fb55bc713540643c6f8eae702d101cea8c59afc49cfc505fc37/b0243397-f89e-4ea1-a537-20e5f16b4aa2qa9ukv7d.jpeg', '2025-04-24 15:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'minh', 'minh@gmail.com', '$2y$10$OaY6xA264xgjC8LK/Y642.txqkF0sGv/vPydxTA9VsB4VzVMdigAi', '2025-04-15 16:45:32', 'user'),
(2, 'admin', 'admin@gmail.com', '$2y$10$aV7T4LJBc48xWe9RSfm7zeq3U1AaiM.I8K6BsRi5wmA8NWUGg7Uq6', '2025-04-15 16:47:32', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
