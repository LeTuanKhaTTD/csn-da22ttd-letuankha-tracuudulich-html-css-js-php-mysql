<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu HinhAnh
$query = "SELECT HinhAnh.mahinhanh, HinhAnh.tenanh, HinhAnh.mota, HinhAnh.file_path, DiemDuLich.tendiemdl 
          FROM HinhAnh
          LEFT JOIN DiemDuLich ON HinhAnh.madiemdl = DiemDuLich.madiemdl";
$result = $conn->query($query);

// Thêm hình ảnh mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tenanh = $_POST['tenanh'];
    $mota = $_POST['mota'];
    $madiemdl = $_POST['madiemdl'];

    // Xử lý upload file
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $upload_dir = '../images/'; // Thư mục lưu trữ file
        $file_name = basename($_FILES['file']['name']);
        $target_file = $upload_dir . $file_name;

        // Kiểm tra và di chuyển file
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO HinhAnh (tenanh, mota, madiemdl, file_path) 
                    VALUES ('$tenanh', '$mota', $madiemdl, '$file_name')";
            if ($conn->query($sql) === TRUE) {
                echo "Hình ảnh đã được thêm thành công!";
            } else {
                echo "Lỗi khi thêm hình ảnh: " . $conn->error;
            }
        } else {
            echo "Lỗi khi tải lên file.";
        }
    } else {
        echo "Vui lòng chọn một file hợp lệ!";
    }
}

// Xóa hình ảnh
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Lấy đường dẫn file trước khi xóa
    $query_file = "SELECT file_path FROM HinhAnh WHERE mahinhanh = $id";
    $result_file = $conn->query($query_file);
    if ($result_file && $row = $result_file->fetch_assoc()) {
        $file_path = '../images' . $row['file_path'];

        // Xóa file trên server
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Xóa dữ liệu trong database
    $sql = "DELETE FROM HinhAnh WHERE mahinhanh = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Hình ảnh đã được xóa!";
    } else {
        echo "Lỗi khi xóa hình ảnh: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hình Ảnh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Hình Ảnh</h2>

        <!-- Form thêm mới hình ảnh -->
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="tenanh" class="form-label">Tên Ảnh</label>
                <input type="text" class="form-control" id="tenanh" name="tenanh" required>
            </div>
            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="mota" name="mota"></textarea>
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
            <div class="mb-3">
                <label for="file" class="form-label">Tải lên Hình Ảnh</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-success" name="add">Thêm Hình Ảnh</button>
        </form>

        <!-- Danh sách hình ảnh -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Ảnh</th>
                    <th>Mô Tả</th>
                    <th>Điểm Du Lịch</th>
                    <th>Hình Ảnh</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['mahinhanh']; ?></td>
                        <td><?php echo $row['tenanh']; ?></td>
                        <td><?php echo $row['mota']; ?></td>
                        <td><?php echo $row['tendiemdl']; ?></td>
                        <td>
                            <img src="../images/<?php echo $row['file_path']; ?>" alt="Hình Ảnh" style="width: 100px; height: auto;">
                        </td>
                        <td>
                            <a href="QL_HinhAnh.php?delete=<?php echo $row['mahinhanh']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
