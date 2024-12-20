<?php
include '../travel_user/db_connect.php';

// Lấy dữ liệu người dùng
$query = "SELECT * FROM NguoiDung";
$result = $conn->query($query);

// Thêm người dùng mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tennguoidung = $_POST['tennguoidung'];
    $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT);
    $vaiTro = $_POST['vaiTro'];

    $sql = "INSERT INTO NguoiDung (tennguoidung, matkhau, vaiTro) VALUES ('$tennguoidung', '$matkhau', '$vaiTro')";
    if ($conn->query($sql) === TRUE) {
        echo "Người dùng đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm người dùng: " . $conn->error;
    }
}

// Xóa người dùng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM NguoiDung WHERE manguoidung = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Người dùng đã được xóa!";
    } else {
        echo "Lỗi khi xóa người dùng: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý Người Dùng</h2>

        <!-- Form thêm mới người dùng -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="tennguoidung" class="form-label">Tên Người Dùng</label>
                <input type="text" class="form-control" id="tennguoidung" name="tennguoidung" required>
            </div>
            <div class="mb-3">
                <label for="matkhau" class="form-label">Mật Khẩu</label>
                <input type="password" class="form-control" id="matkhau" name="matkhau" required>
            </div>
            <div class="mb-3">
                <label for="vaiTro" class="form-label">Vai Trò</label>
                <select class="form-select" id="vaiTro" name="vaiTro" required>
                    <option value="admin">Quản trị viên</option>
                    <option value="user">Người dùng</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success" name="add">Thêm Người Dùng</button>
        </form>

        <!-- Danh sách người dùng -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Người Dùng</th>
                    <th>Vai Trò</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['manguoidung']; ?></td>
                        <td><?php echo $row['tennguoidung']; ?></td>
                        <td><?php echo $row['vaiTro']; ?></td>
                        <td>
                            <a href="QL_NguoiDung.php?delete=<?php echo $row['manguoidung']; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
