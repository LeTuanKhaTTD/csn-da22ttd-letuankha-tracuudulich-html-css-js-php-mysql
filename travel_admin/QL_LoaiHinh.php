<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu loại hình
$query = "SELECT * FROM LoaiHinh";
$result = $conn->query($query);

// Thêm loại hình mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tenloaihinh = $_POST['tenloaihinh'];
    $mota = $_POST['mota'];

    $sql = "INSERT INTO LoaiHinh (tenloaihinh, mota) VALUES ('$tenloaihinh', '$mota')";
    if ($conn->query($sql) === TRUE) {
        echo "Loại hình đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm loại hình: " . $conn->error;
    }
}

// Xóa loại hình
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM LoaiHinh WHERE maloaihinh = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Loại hình đã được xóa!";
    } else {
        echo "Lỗi khi xóa loại hình: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Hình</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Loại Hình</h2>

        <!-- Form thêm mới loại hình -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="tenloaihinh" class="form-label">Tên Loại Hình</label>
                <input type="text" class="form-control" id="tenloaihinh" name="tenloaihinh" required>
            </div>
            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="mota" name="mota" required></textarea>
            </div>
            <button type="submit" class="btn btn-success" name="add">Thêm Loại Hình</button>
        </form>

        <!-- Danh sách loại hình -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Loại Hình</th>
                    <th>Mô Tả</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['maloaihinh']; ?></td>
                        <td><?php echo $row['tenloaihinh']; ?></td>
                        <td><?php echo $row['mota']; ?></td>
                        <td>
                            <a href="QL_LoaiHinh.php?delete=<?php echo $row['maloaihinh']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
