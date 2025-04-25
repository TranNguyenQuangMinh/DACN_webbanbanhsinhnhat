<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Chuyển hướng về trang chủ nếu không phải admin
    exit;
}

// Xử lý khi form thêm sản phẩm được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image_url = trim($_POST['image_url']);

    // Chèn sản phẩm vào bảng Products
    $sql = "INSERT INTO Products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':image_url' => $image_url
    ]);

    $success_message = "Sản phẩm đã được thêm thành công!";
}

// Xử lý khi form xóa sản phẩm được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);

    // Xóa sản phẩm khỏi bảng Products
    $sql = "DELETE FROM Products WHERE id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);

    $success_message = "Sản phẩm đã được xóa thành công!";
}

// Xử lý khi form sửa sản phẩm được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $product_id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image_url = trim($_POST['image_url']);

    // Cập nhật sản phẩm trong bảng Products
    $sql = "UPDATE Products SET name = :name, description = :description, price = :price, image_url = :image_url WHERE id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':image_url' => $image_url,
        ':product_id' => $product_id
    ]);

    $success_message = "Sản phẩm đã được cập nhật thành công!";
}

// Lấy thông tin sản phẩm cần sửa nếu có
$edit_product = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $sql = "SELECT * FROM Products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $edit_id]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM Products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Quản lý sản phẩm</h1>
    <nav>
        <a href="sales_stats.php">Thống kê doanh số</a>
            <a href="logout.php">Đăng xuất</a>
    </nav>
</header>
<main>
    <!-- Hiển thị thông báo thành công -->
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <!-- Form thêm/sửa sản phẩm -->
    <h2><?php echo $edit_product ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h2>
    <form method="POST" action="">
        <?php if ($edit_product): ?>
            <input type="hidden" name="edit_product" value="1">
            <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
        <?php else: ?>
            <input type="hidden" name="add_product" value="1">
        <?php endif; ?>
        
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>">
        
        <label for="description">Mô tả sản phẩm:</label>
        <textarea id="description" name="description" required><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
        
        <label for="price">Giá sản phẩm (VND):</label>
        <input type="number" id="price" name="price" required value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>">
        
        <label for="image_url">URL hình ảnh:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo $edit_product ? htmlspecialchars($edit_product['image_url']) : ''; ?>">
        
        <button type="submit"><?php echo $edit_product ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm'; ?></button>
        <?php if ($edit_product): ?>
            <a href="add_product.php" class="btn-cancel">Hủy</a>
        <?php endif; ?>
    </form>

    <!-- Danh sách sản phẩm -->
    <h2>Danh sách sản phẩm</h2>
    <?php if (count($products) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" style="width: 50px; height: auto;">
                            <?php else: ?>
                                Không có hình ảnh
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Nút sửa sản phẩm -->
                            <a href="add_product.php?edit_id=<?php echo $product['id']; ?>" class="btn-edit">Sửa</a>
                            
                            <!-- Nút xóa sản phẩm -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_product" value="1">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có sản phẩm nào.</p>
    <?php endif; ?>
</main>
<footer>
    <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
</footer>
</body>
</html>