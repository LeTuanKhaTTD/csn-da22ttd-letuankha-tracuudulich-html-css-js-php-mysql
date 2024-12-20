<?php
include 'travel_user/db_connect.php';

// Lấy ID từ URL
$id = $_GET['id'] ?? 0;

if ($id > 0) {
    $sql = "SELECT * FROM locations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $location = $result->fetch_assoc();
    } else {
        die("Không tìm thấy địa điểm.");
    }
} else {
    die("ID không hợp lệ.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết điểm du lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $location['name']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <!-- Hiển thị ảnh của điểm du lịch -->
                <img src="<?php echo !empty($location['photo_gallery']) ? $location['photo_gallery'] : 'default-image.jpg'; ?>" class="img-fluid" alt="<?php echo $location['name']; ?>">
            </div>
            <div class="col-md-6">
                <h3>Mô tả</h3>
                <p><?php echo $location['description']; ?></p>
                <h4>Địa chỉ</h4>
                <p><?php echo $location['address']; ?></p>
                <h4>Loại hình du lịch</h4>
                <p><?php echo $location['tourism_type']; ?></p>
                <h4>Tiện ích gần đây</h4>
                <p><?php echo $location['nearby_facilities']; ?></p>
                <h4>Khoảng cách từ trung tâm</h4>
                <p><?php echo $location['distance_from_city_center']; ?></p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-4">Trở về trang chủ</a>
    </div>
</body>
</html>
