<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Kiểm tra các trường bắt buộc
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Vui lòng điền đầy đủ thông tin.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Mật khẩu và xác nhận mật khẩu không khớp.";
    } else {
        // Kiểm tra xem username hoặc email đã tồn tại chưa
        $sql = "SELECT * FROM Users WHERE username = :username OR email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':username' => $username, ':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error_message = "Tên đăng nhập hoặc email đã tồn tại.";
        } else {
            // Mã hóa mật khẩu và lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashed_password]);

            $success_message = "Đăng ký thành công! Hãy đăng nhập.";
            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
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
            </a>
   
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

        <?php if (isset($success_message)): ?>
            <p style="color:green;"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Đăng ký</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>