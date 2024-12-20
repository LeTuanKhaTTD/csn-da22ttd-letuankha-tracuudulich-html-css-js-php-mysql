<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu DanhGia
$query = "SELECT DanhGia.madanhgia, DanhGia.binhluan, NguoiDung.tennguoidung, DiemDuLich.tendiemdl 
          FROM DanhGia
          LEFT JOIN NguoiDung ON DanhGia.manguoidung = NguoiDung.manguoidung
          LEFT JOIN DiemDuLich ON DanhGia.madiemdl = DiemDuLich.madiemdl";
$result = $conn->query($query);

// Xóa đánh giá
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM DanhGia WHERE madanhgia = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Đánh giá đã được xóa!";
    } else {
        echo "Lỗi khi xóa đánh giá: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đánh Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Đánh Giá</h2>

        <!-- Danh sách đánh giá -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bình Luận</th>
                    <th>Người Dùng</th>
                    <th>Điểm Du Lịch</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['madanhgia']; ?></td>
                        <td><?php echo $row['binhluan']; ?></td>
                        <td><?php echo $row['tennguoidung']; ?></td>
                        <td><?php echo $row['tendiemdl']; ?></td>
                        <td>
                            <a href="QL_DanhGia.php?delete=<?php echo $row['madanhgia']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
