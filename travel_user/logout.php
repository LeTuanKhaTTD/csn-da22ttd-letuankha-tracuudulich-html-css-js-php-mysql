<?php
// Bắt đầu hoặc khôi phục session hiện tại
session_start();

// Xóa toàn bộ biến trong session
$_SESSION = [];

// Hủy session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy hoàn toàn session hiện tại
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập
header("Location: login.php");
exit();
?>
