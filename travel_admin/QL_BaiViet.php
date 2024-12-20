<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu BaiViet
$query = "SELECT BaiViet.mabaiviet, BaiViet.tenbaiviet, BaiViet.noidung, DiemDuLich.tendiemdl 
          FROM BaiViet
          LEFT JOIN DiemDuLich ON BaiViet.madiemdl = DiemDuLich.madiemdl";
$result = $conn->query($query);

// Thêm bài viết mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tenbaiviet = $_POST['tenbaiviet'];
    $noidung = $_POST['noidung'];
    $madiemdl = $_POST['madiemdl'];

    $sql = "INSERT INTO BaiViet (tenbaiviet, noidung, madiemdl) VALUES ('$tenbaiviet', '$noidung', $madiemdl)";
    if ($conn->query($sql) === TRUE) {
        echo "Bài viết đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm bài viết: " . $conn->error;
    }
}

// Xóa bài viết
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM BaiViet WHERE mabaiviet = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Bài viết đã được xóa!";
    } else {
        echo "Lỗi khi xóa bài viết: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Bài Viết</h2>

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="tenbaiviet" class="form-label">Tên Bài Viết</label>
                <input type="text" class="form-control" id="tenbaiviet" name="tenbaiviet" required>
            </div>
            <div class="mb-3">
                <label for="noidung" class="form-label">Nội Dung</label>
                <textarea class="form-control" id="noidung" name="noidung" required></textarea>
            </div>
            <div class="mb-3">
                <label for="madiemdl" class="form-label">Điểm Du Lịch</label>
                <select class="form-select" id="madiemdl" name="madiemdl" required>
                    <?php
                    $diemdl_query = "SELECT * FROM DiemDuLich";
                    $diemdl_result = $conn->query($diemdl_query);
                    while ($diemdl_row = $diemdl_result->fetch_assoc()) {
                        echo "<option value='{$diemdl_row['madiemdl']}'>{$diemdl_row['tendiemdl']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success" name="add">Thêm Bài Viết</button>
        </form>

        <!-- Danh sách bài viết -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Bài Viết</th>
                    <th>Nội Dung</th>
                    <th>Điểm Du Lịch</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['mabaiviet']; ?></td>
                        <td><?php echo $row['tenbaiviet']; ?></td>
                        <td><?php echo $row['noidung']; ?></td>
                        <td><?php echo $row['tendiemdl']; ?></td>
                        <td>
                            <a href="QL_BaiViet.php?delete=<?php echo $row['mabaiviet']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
