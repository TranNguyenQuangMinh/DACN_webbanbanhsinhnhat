<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Chèn thông tin vào cơ sở dữ liệu
    $sql = "INSERT INTO Contacts (name, email, phone, message) VALUES (:name, :email, :phone, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':message' => $message
    ]);

    $success_message = "Cảm ơn bạn đã liên hệ với chúng tôi!";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<header>
        <h1>Giỏ hàng của bạn</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="product.php">Sản phẩm</a>
            <a href="cart.php">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="contact.php">Liên hệ</a>
   
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Đăng xuất</a> <!-- Hiển thị khi đăng nhập -->
    <?php else: ?>
        <a href="login.php">Đăng nhập/Đăng ký</a> <!-- Hiển thị khi chưa đăng nhập -->
    <?php endif; ?>
        </nav>
    </header>
    <main>
        <!-- Hiển thị thông báo thành công -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Form liên hệ -->
        <form method="POST" action="">
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Số điện thoại:</label>
            <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}" title="Số điện thoại phải gồm 10 chữ số.">

            <label for="message">Tin nhắn:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Gửi</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>