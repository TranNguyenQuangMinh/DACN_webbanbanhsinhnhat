<?php
session_start(); // Bắt đầu session
include 'db_connection.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id']; // Lấy user_id từ session
    $quantity = 1; // Số lượng mặc định là 1

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $sql = "SELECT * FROM Cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // Nếu sản phẩm đã có, tăng số lượng
        $sql = "UPDATE Cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    } else {
        // Nếu sản phẩm chưa có, thêm vào giỏ hàng
        $sql = "INSERT INTO Cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id, ':quantity' => $quantity]);
    }

    // Lưu thông báo thành công vào session
    $_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng thành công!";

    // Chuyển hướng về trang sản phẩm
    header("Location: product.php");
    exit;
}
?>