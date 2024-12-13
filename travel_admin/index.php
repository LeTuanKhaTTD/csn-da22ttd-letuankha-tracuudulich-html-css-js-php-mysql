<?php
session_start();
include('../auth.php');  // Kiểm tra quyền truy cập
include('../db_connect.php'); // Kết nối cơ sở dữ liệu

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Điều hướng về trang chủ nếu không phải admin
    exit();
}

// Lấy danh sách điểm du lịch từ cơ sở dữ liệu
$query = "SELECT * FROM tourist_spots";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Quản lý Điểm Du Lịch</h1>
        <a href="add.php" class="btn btn-primary mb-3">Thêm mới</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
