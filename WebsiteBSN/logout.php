<?php
session_start(); // Bắt đầu session

// Xoá tất cả dữ liệu trong session
session_unset();

// Huỷ bỏ session
session_destroy();

// Chuyển hướng về trang chủ
header("Location: index.php");
exit;
?>