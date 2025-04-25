<?php
// Thông tin kết nối tới cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ MySQL
$dbname = 'CakeShop'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên đăng nhập MySQL
$password = ''; // Mật khẩu MySQL

try {
    // Kết nối với cơ sở dữ liệu bằng PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Thiết lập chế độ lỗi cho PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Xử lý lỗi khi không thể kết nối
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// Hàm đóng kết nối (nếu cần)
function closeConnection($conn) {
    $conn = null;
}
?>