<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin giỏ hàng
$user_id = $_SESSION['user_id']; // Lấy user_id từ session
$sql = "SELECT Products.id AS product_id, Products.name, Products.price, Cart.quantity 
        FROM Cart
        JOIN Products ON Cart.product_id = Products.id
        WHERE Cart.user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý khi người dùng nhấn nút "Xóa"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $product_id = intval($_POST['delete_product_id']);
    $sql = "DELETE FROM Cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    
    // Lưu thông báo xóa thành công vào session
    $_SESSION['success_message'] = "Sản phẩm đã được xóa khỏi giỏ hàng thành công!";
    
    // Chuyển hướng về chính trang giỏ hàng
    header("Location: cart.php");
    exit;
}

// Xử lý khi người dùng nhấn nút "Thanh toán"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    try {
        // Validate dữ liệu
        $errors = [];
        if (empty($_POST['customer_name'])) {
            $errors[] = "Vui lòng nhập tên khách hàng";
        }
        if (empty($_POST['phone'])) {
            $errors[] = "Vui lòng nhập số điện thoại";
        }
        if (empty($_POST['delivery_time'])) {
            $errors[] = "Vui lòng chọn thời gian nhận bánh";
        }
        if (empty($_POST['delivery_address'])) {
            $errors[] = "Vui lòng nhập địa chỉ giao hàng";
        }

        if (empty($errors)) {
            // Bắt đầu transaction
            $conn->beginTransaction();

            // Tạo đơn hàng mới
            $sql = "INSERT INTO Orders (user_id, customer_name, phone, delivery_time, delivery_address, message, total_amount, status, created_at) 
                    VALUES (:user_id, :customer_name, :phone, :delivery_time, :delivery_address, :message, :total_amount, 'pending', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':customer_name' => $_POST['customer_name'],
                ':phone' => $_POST['phone'],
                ':delivery_time' => $_POST['delivery_time'],
                ':delivery_address' => $_POST['delivery_address'],
                ':message' => $_POST['message'],
                ':total_amount' => $_POST['total_amount']
            ]);
            $order_id = $conn->lastInsertId();

            // Thêm chi tiết đơn hàng
            $sql = "INSERT INTO OrderDetails (order_id, product_id, quantity, price) 
                    SELECT :order_id, product_id, quantity, price 
                    FROM Cart 
                    JOIN Products ON Cart.product_id = Products.id 
                    WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':order_id' => $order_id,
                ':user_id' => $user_id
            ]);

            // Xóa giỏ hàng
            $sql = "DELETE FROM Cart WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);

            // Commit transaction
            $conn->commit();

            $_SESSION['success_message'] = "Pmoment đã tiếp nhận thông tin đặt hàng của khách hàng, sẽ có nhân viên liên hệ lại với mình để xác nhận đơn hàng. Cảm ơn quý khách đã tin tưởng và chọn dịch vụ của Pmoments";
            header("Location: cart.php");
            exit;
        } else {
            $_SESSION['error_message'] = implode("<br>", $errors);
        }
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollBack();
        $_SESSION['error_message'] = "Có lỗi xảy ra khi tạo đơn hàng: " . $e->getMessage();
    }
}

// Tính tổng tiền
$total_amount = 0;
foreach ($cartItems as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Hiển thị thông báo từ session nếu có
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
}

// Hiển thị thông báo lỗi từ session nếu có
$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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
        <h2>Giỏ hàng của bạn</h2>
        
        <!-- Hiển thị thông báo thành công -->
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Hiển thị thông báo lỗi -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (count($cartItems) > 0): ?>
            <div class="cart-container">
                <div class="cart-items">
                    <ul>
                        <?php foreach ($cartItems as $item): ?>
                            <li>
                                <div class="cart-item">
                                    <div class="item-info">
                                        <h3><?php echo $item['name']; ?></h3>
                                        <p class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</p>
                                    </div>
                                    <div class="item-quantity">
                                        <span>Số lượng: <?php echo $item['quantity']; ?></span>
                                    </div>
                                    <div class="item-total">
                                        <p>Tổng: <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</p>
                                    </div>
                                    <form method="POST" action="" class="delete-form">
                                        <input type="hidden" name="delete_product_id" value="<?php echo $item['product_id']; ?>">
                                        <button type="submit" class="btn-delete-product">Xóa</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="cart-summary">
                    <h3>Tổng cộng</h3>
                    <div class="summary-item">
                        <span>Tạm tính:</span>
                        <span><?php echo number_format($total_amount, 0, ',', '.'); ?> VND</span>
                    </div>
                    <div class="summary-item">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="summary-item total">
                        <span>Thành tiền:</span>
                        <span><?php echo number_format($total_amount, 0, ',', '.'); ?> VND</span>
                    </div>
                    
                    <form method="POST" action="" class="checkout-form">
                        <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                        
                        <div class="form-group">
                            <label for="customer_name">Tên khách hàng:</label>
                            <input type="text" id="customer_name" name="customer_name" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label for="delivery_time">Thời gian nhận bánh:</label>
                            <input type="datetime-local" id="delivery_time" name="delivery_time" required>
                        </div>

                        <div class="form-group">
                            <label for="delivery_address">Địa chỉ giao hàng:</label>
                            <textarea id="delivery_address" name="delivery_address" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="message">Lời chúc:</label>
                            <textarea id="message" name="message"></textarea>
                        </div>

                        <button type="submit" name="checkout" class="btn-checkout">Thanh toán</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Giỏ hàng của bạn hiện đang trống.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>