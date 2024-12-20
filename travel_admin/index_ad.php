<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../travel_user/login.php");
    exit();
}

$admin_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Liên kết đến file CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="sidebar">
        <h3>Quản Trị</h3>
      <a href="../travel_user/logout.php">Đăng Xuất</a>
    </div>

    <div class="content">
        <div class="container">
            <h1>Chào mừng bạn, <?php echo $admin_username; ?></h1>
            <p>Đây là trang quản trị của hệ thống. Bạn có thể quản lý tất cả các tỉnh thành, điểm du lịch, bài viết và đánh giá ở đây.</p>

            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Tỉnh Thành</h5>
                            <p class="card-text">Thêm, sửa, xóa tỉnh thành.</p>
                            <a href="QL_TinhThanh.php" class="btn btn-primary">Quản lý Tỉnh Thành</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Điểm Du Lịch</h5>
                            <p class="card-text">Thêm, sửa, xóa điểm du lịch.</p>
                            <a href="QL_DiemDuLich.php" class="btn btn-primary">Quản lý Điểm Du Lịch</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Bài Viết</h5>
                            <p class="card-text">Quản lý các bài viết giới thiệu địa phương và điểm du lịch.</p>
                            <a href="QL_BaiViet.php" class="btn btn-primary">Quản lý Bài Viết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Đánh Giá</h5>
                            <p class="card-text">Quản lý đánh giá của người dùng về các điểm du lịch.</p>
                            <a href="QL_DanhGia.php" class="btn btn-primary">Quản lý Đánh Giá</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Hình Ảnh</h5>
                            <p class="card-text">Thêm, sửa, xóa hình ảnh liên quan đến điểm du lịch.</p>
                            <a href="QL_HinhAnh.php" class="btn btn-primary">Quản lý Hình Ảnh</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Tiện Ích</h5>
                            <p class="card-text">Thêm, sửa, xóa tiện ích tại các điểm du lịch.</p>
                            <a href="QL_TienIch.php" class="btn btn-primary">Quản lý Tiện Ích</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Loại Hình</h5>
                            <p class="card-text">Thêm, sửa, xóa các loại hình du lịch.</p>
                            <a href="QL_LoaiHinh.php" class="btn btn-primary">Quản lý Loại Hình</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản Lý Người Dùng</h5>
                            <p class="card-text">Quản lý thông tin và vai trò người dùng.</p>
                            <a href="QL_NguoiDung.php" class="btn btn-primary">Quản lý Người Dùng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Hệ thống quản trị du lịch.</p>
    </div>

</body>
</html>