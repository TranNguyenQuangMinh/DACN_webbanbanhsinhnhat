<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM Products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị thông báo từ session nếu có
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
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
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php">Đăng nhập/Đăng ký</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <h2>DANH SÁCH BÁNH</h2>
    
    <!-- Hiển thị thông báo thành công -->
    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <ul>
        <?php foreach ($products as $product): ?>
            <li style="list-style: none; margin-bottom: 20px;">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" style="width:150px; height:auto; display:block; margin-bottom:10px; ">
                <strong><?php echo $product['name']; ?></strong>
                <span><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</span>
                <form method="POST" action="add_to_cart.php" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn-add-product">Thêm vào giỏ hàng</button>
                </form>
                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn-details">Xem chi tiết</a>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
<footer>
    <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
</footer>
</body>
</html>