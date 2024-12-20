<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../travel_user/login.php");
    exit();
}

include '../travel_user/db_connect.php';

// Xử lý thêm tỉnh thành mới
if (isset($_POST['add'])) {
    $tentinh = $_POST['tentinh'];
    $mota = $_POST['mota'];

    $sql = "INSERT INTO TinhThanh (tentinh, mota) VALUES ('$tentinh', '$mota')";
    if (mysqli_query($conn, $sql)) {
        $message = "Tỉnh thành đã được thêm thành công.";
    } else {
        $message = "Lỗi khi thêm tỉnh thành.";
    }
}

// Xử lý xóa tỉnh thành
if (isset($_GET['delete'])) {
    $matinh = $_GET['delete'];
    $sql = "DELETE FROM TinhThanh WHERE matinh = $matinh";
    if (mysqli_query($conn, $sql)) {
        $message = "Tỉnh thành đã được xóa thành công.";
    } else {
        $message = "Lỗi khi xóa tỉnh thành.";
    }
}

// Xử lý sửa tỉnh thành
if (isset($_POST['edit'])) {
    $matinh = $_POST['matinh'];
    $tentinh = $_POST['tentinh'];
    $mota = $_POST['mota'];

    $sql = "UPDATE TinhThanh SET tentinh = '$tentinh', mota = '$mota' WHERE matinh = $matinh";
    if (mysqli_query($conn, $sql)) {
        $message = "Tỉnh thành đã được sửa thành công.";
    } else {
        $message = "Lỗi khi sửa tỉnh thành.";
    }
}

// Lấy danh sách tỉnh thành
$sql = "SELECT * FROM TinhThanh";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Lý Tỉnh Thành</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản Lý Tỉnh Thành</h2>

        <!-- Hiển thị thông báo -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form thêm tỉnh thành mới -->
        <h3 class="mt-4">Thêm Tỉnh Thành</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="tentinh" class="form-label">Tên Tỉnh</label>
                <input type="text" class="form-control" name="tentinh" required>
            </div>
            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control" name="mota" rows="3" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Thêm</button>
        </form>

        <!-- Danh sách tỉnh thành -->
        <h3 class="mt-4">Danh Sách Tỉnh Thành</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mã Tỉnh</th>
                    <th scope="col">Tên Tỉnh</th>
                    <th scope="col">Mô Tả</th>
                    <th scope="col">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['matinh']; ?></td>
                        <td><?php echo $row['tentinh']; ?></td>
                        <td><?php echo $row['mota']; ?></td>
                        <td>
                            <a href="QL_TinhThanh.php?edit=<?php echo $row['matinh']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="QL_TinhThanh.php?delete=<?php echo $row['matinh']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tỉnh này không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Nếu cần sửa tỉnh thành -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $matinh = $_GET['edit'];
            $edit_sql = "SELECT * FROM TinhThanh WHERE matinh = $matinh";
            $edit_result = mysqli_query($conn, $edit_sql);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>
            <h3 class="mt-4">Sửa Tỉnh Thành</h3>
            <form method="POST">
                <input type="hidden" name="matinh" value="<?php echo $edit_row['matinh']; ?>">
                <div class="mb-3">
                    <label for="tentinh" class="form-label">Tên Tỉnh</label>
                    <input type="text" class="form-control" name="tentinh" value="<?php echo $edit_row['tentinh']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mota" class="form-label">Mô Tả</label>
                    <textarea class="form-control" name="mota" rows="3" required><?php echo $edit_row['mota']; ?></textarea>
                </div>
                <button type="submit" name="edit" class="btn btn-success">Cập Nhật</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
