<?php
include 'db_connection.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM Products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu sản phẩm không tồn tại
if (!$product) {
    die("Sản phẩm không tồn tại.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
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
        <h2><?php echo $product['name']; ?></h2>
        <p><strong>Giá:</strong> <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
        <p><strong>Mô tả:</strong> <?php echo $product['description']; ?></p>
        <?php if (!empty($product['image_url'])): ?>
            <img src="<?php echo $product['image_url']; ?>" alt="Hình ảnh sản phẩm" style="max-width: 600px;">
        <?php endif; ?>
        <a href="product.php" class="btn-back">Quay lại</a>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>