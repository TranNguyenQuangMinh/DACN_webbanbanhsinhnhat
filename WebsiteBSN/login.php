<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM Users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Đăng nhập thành công
        $_SESSION['user_id'] = $user['id']; // Lưu user_id vào session
        $_SESSION['username'] = $user['username']; // Lưu username vào session
        $_SESSION['role'] = $user['role']; // Lưu vai trò (role) vào session

        // Chuyển hướng dựa trên quyền (role)
        if ($user['role'] === 'admin') {
            header("Location: add_product.php"); // Chuyển đến trang thêm sản phẩm nếu là admin
        } else {
            header("Location: index.php"); // Chuyển đến trang chủ nếu là user thường
        }
        exit;
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
        <?php if (isset($error_message)): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Đăng nhập</button>
        </form>
        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>.</p>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>