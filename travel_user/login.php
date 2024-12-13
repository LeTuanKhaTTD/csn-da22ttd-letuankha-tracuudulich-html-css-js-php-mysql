
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center my-5">Đăng Nhập</h2>
        <?php
        session_start();
        // Hiển thị thông báo lỗi nếu có
        if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']);  // Xóa thông báo lỗi sau khi hiển thị
                ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="auth.php">
            <div class="form-group">
                <label for="username">Tên người dùng</label>
                <input type="text" class="form-control" name="username" placeholder="Tên người dùng" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>
        <div class="text-center mt-4">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
        </div>
    </div>
</body>
</html>
