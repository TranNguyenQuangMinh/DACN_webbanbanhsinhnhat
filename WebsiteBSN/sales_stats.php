<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Chuyển hướng về trang chủ nếu không phải admin
    exit;
}

// Lấy thống kê sản phẩm đã bán trong ngày
$today = date('Y-m-d');
$sql = "SELECT p.name, p.id, SUM(oi.quantity) as total_sold, SUM(oi.quantity * oi.price) as total_revenue
        FROM OrderDetails oi
        JOIN Products p ON oi.product_id = p.id
        JOIN Orders o ON oi.order_id = o.id
        WHERE DATE(o.created_at) = :today
        GROUP BY p.id, p.name
        ORDER BY total_sold DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([':today' => $today]);
$sales_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng doanh thu trong ngày
$sql = "SELECT SUM(total_amount) as daily_revenue
        FROM Orders
        WHERE DATE(created_at) = :today";
$stmt = $conn->prepare($sql);
$stmt->execute([':today' => $today]);
$daily_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['daily_revenue'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh số</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Thống kê doanh số</h1>
        <nav>
            <a href="add_product.php">Quản lý sản phẩm</a>
                <a href="logout.php">Đăng xuất</a>
        </nav>
    </header>
    <main>
        <h2>Thống kê sản phẩm đã bán trong ngày (<?php echo date('d/m/Y'); ?>)</h2>
        <div class="stats-container">
            <div class="daily-revenue">
                <h3>Tổng doanh thu trong ngày:</h3>
                <p class="revenue"><?php echo number_format($daily_revenue, 0, ',', '.'); ?> VND</p>
            </div>

            <?php if (count($sales_stats) > 0): ?>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales_stats as $stat): ?>
                            <tr>
                                <td><?php echo $stat['name']; ?></td>
                                <td><?php echo $stat['total_sold']; ?></td>
                                <td><?php echo number_format($stat['total_revenue'], 0, ',', '.'); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có sản phẩm nào được bán trong ngày hôm nay.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html> 