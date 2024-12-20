<?php
session_start();
include('./db_connect.php');  

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

$search_result = [];
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];

    // Tìm kiếm các điểm du lịch trong cơ sở dữ liệu
    $query = "SELECT * FROM DiemDuLich WHERE tendiemdl LIKE ? OR diachi LIKE ?";
    $stmt = mysqli_prepare($conn, $query);
    $search_term = "%" . $search_term . "%";
    mysqli_stmt_bind_param($stmt, 'ss', $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $search_result[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu thông tin du lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="GT.php">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="LH.php">Liên hệ</a></li>
                <?php
                // Kiểm tra xem người dùng đã đăng nhập chưa
                if (isset($_SESSION['username'])): ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <div class="search-section d-flex align-items-center justify-content-center text-center">
        <div>
            <h1 class="text-white fw-bold">Tìm kiếm điểm du lịch</h1>
            <p class="text-white-50">Khám phá các địa điểm du lịch hấp dẫn khắp Việt Nam</p>
            <form id="searchForm" class="mt-4" method="get" action="index.php">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Nhập tên điểm du lịch hoặc địa phương" value="<?php echo isset($search_term) ? $search_term : ''; ?>">
                    <button class="btn btn-light" type="submit">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container my-5">
        <h2 class="text-center mb-4">Kết quả tìm kiếm</h2>
        <div class="row" id="results">
            <?php if (!empty($search_result)): ?>
                <?php foreach ($search_result as $spot): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="../images<?php echo $spot['hinhanh']; ?>" class="card-img-top" alt="<?php echo $spot['tenanh']; ?>">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo $spot['tendiemdl']; ?></h5>
                        <p class="card-text"><?php echo $spot['diachi']; ?></p>
                            <a href="view.php?id=<?php echo $spot['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Không tìm thấy điểm du lịch nào với từ khóa này.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="container my-5">
    <h2 class="text-center mb-4">Các địa điểm du lịch nổi bật</h2>
    <div class="row g-4" id="featured-results">
        <?php
        // Kiểm tra nếu không có tìm kiếm, hiển thị các điểm du lịch nổi bật
        if (empty($search_result)): 
            // Lấy các điểm du lịch nổi bật từ cơ sở dữ liệu (ví dụ: top 3 điểm du lịch nổi bật)
            $query_featured = "SELECT * FROM DiemDuLich ORDER BY giave DESC LIMIT 3";  // Thay đổi tiêu chí lọc nếu cần
            $result_featured = mysqli_query($conn, $query_featured);

            while ($spot = mysqli_fetch_assoc($result_featured)): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="../images<?php echo $spot['file_path']; ?>" class="card-img-top img-fluid rounded-top" alt="<?php echo $spot['tendiemdl']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate"><?php echo $spot['tendiemdl']; ?></h5>
                            <p class="card-text text-muted"><?php echo $spot['diachi']; ?></p>
                            <div class="mt-auto">
                                <a href="view.php?id=<?php echo $spot['madiemdl']; ?>" class="btn btn-primary btn-block w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-left">
            <div class="row text-center text-md-left">
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Tra Cứu Du Lịch</h5>
                    <p>Khám phá Việt Nam qua những điểm đến độc đáo. Chúng tôi cung cấp thông tin chính xác và hữu ích để hành trình của bạn trở nên dễ dàng hơn.</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Liên kết nhanh</h5>
                    <p><a href="#" class="text-white text-decoration-none">Trang chủ</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Giới thiệu</a></p>
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
