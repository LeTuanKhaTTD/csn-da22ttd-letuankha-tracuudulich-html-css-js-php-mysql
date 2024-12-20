<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu TienIch
$query = "SELECT TienIch.matienich, TienIch.tentienich, TienIch.diachitienich, TienIch.hinhanh, DiemDuLich.tendiemdl 
          FROM TienIch
          LEFT JOIN DiemDuLich ON TienIch.madiemdl = DiemDuLich.madiemdl";
$result = $conn->query($query);

// Thêm tiện ích mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tentienich = $_POST['tentienich'];
    $diachitienich = $_POST['diachitienich'];
    $hinhanh = $_POST['hinhanh'];
    $madiemdl = $_POST['madiemdl'];

    $sql = "INSERT INTO TienIch (tentienich, diachitienich, hinhanh, madiemdl) 
            VALUES ('$tentienich', '$diachitienich', '$hinhanh', $madiemdl)";
    if ($conn->query($sql) === TRUE) {
        echo "Tiện ích đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm tiện ích: " . $conn->error;
    }
}

// Xóa tiện ích
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM TienIch WHERE matienich = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Tiện ích đã được xóa!";
    } else {
        echo "Lỗi khi xóa tiện ích: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tiện Ích</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Tiện Ích</h2>

        <!-- Form thêm mới tiện ích -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="tentienich" class="form-label">Tên Tiện Ích</label>
                <input type="text" class="form-control" id="tentienich" name="tentienich" required>
            </div>
            <div class="mb-3">
                <label for="diachitienich" class="form-label">Địa Chỉ Tiện Ích</label>
                <input type="text" class="form-control" id="diachitienich" name="diachitienich">
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình Ảnh</label>
                <input type="text" class="form-control" id="hinhanh" name="hinhanh">
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
            <button type="submit" class="btn btn-success" name="add">Thêm Tiện Ích</button>
        </form>

        <!-- Danh sách tiện ích -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Tiện Ích</th>
                    <th>Địa Chỉ</th>
                    <th>Hình Ảnh</th>
                    <th>Điểm Du Lịch</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['matienich']; ?></td>
                        <td><?php echo $row['tentienich']; ?></td>
                        <td><?php echo $row['diachitienich']; ?></td>
                        <td><?php echo $row['hinhanh']; ?></td>
                        <td><?php echo $row['tendiemdl']; ?></td>
                        <td>
                            <a href="QL_TienIch.php?delete=<?php echo $row['matienich']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
