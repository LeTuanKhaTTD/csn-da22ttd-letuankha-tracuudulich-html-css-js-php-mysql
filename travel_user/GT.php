<?php
session_start();
include('./db_connect.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="GT.php">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Giới thiệu về website -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Giới thiệu về website</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Chào mừng đến với Tra Cứu Du Lịch!</h3>
                <p>Chúng tôi cung cấp thông tin chi tiết về các điểm du lịch ở Việt Nam. Từ những địa điểm nổi tiếng cho đến những vùng đất ít người biết đến, mục tiêu của chúng tôi là giúp bạn dễ dàng tìm thấy các điểm đến hấp dẫn cho chuyến du lịch tiếp theo.</p>
                <p>Trang web này cung cấp các thông tin hữu ích về địa chỉ, hình ảnh, mô tả ngắn gọn, và các tiện ích xung quanh các điểm du lịch. Bạn cũng có thể tìm kiếm nhanh chóng thông qua chức năng tìm kiếm để khám phá những địa điểm gần bạn hoặc theo chủ đề yêu thích.</p>
            </div>
            <div class="col-md-6">
                <img src="images/intro-image.jpg" alt="Giới thiệu" class="img-fluid rounded">
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-left">
            <div class="row text-center text-md-left">
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Tra Cứu Du Lịch</h5>
                    <p>Khám phá Việt Nam qua những điểm đến độc đáo. Chúng tôi cung cấp thông tin chính xác và hữu ích để hành trình của bạn trở nên dễ dàng hơn.</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Liên kết nhanh</h5>
                    <p><a href="index.php" class="text-white text-decoration-none">Trang chủ</a></p>
                    <p><a href="GT.php" class="text-white text-decoration-none">Giới thiệu</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Liên hệ</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Điều khoản</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Liên hệ</h5>
                    <p><i class="fas fa-home me-3"></i> Hà Nội, Việt Nam</p>
                    <p><i class="fas fa-envelope me-3"></i> contact@dulich.com</p>
                    <p><i class="fas fa-phone me-3"></i> +84 123 456 789</p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p class="text-center text-md-center">
                        © 2024 Tra Cứu Du Lịch. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-right">
                        <a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
