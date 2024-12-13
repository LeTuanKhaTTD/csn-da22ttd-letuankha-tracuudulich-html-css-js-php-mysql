<?php
// Bắt đầu phiên làm việc
session_start();

// Xóa tất cả các biến trong session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập sau khi đăng xuất
header("Location: login.php");
exit();
?>
