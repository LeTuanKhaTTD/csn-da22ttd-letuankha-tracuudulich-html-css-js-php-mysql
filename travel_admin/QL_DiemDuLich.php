<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../travel_user/login.php");
    exit();
}

include '../travel_user/db_connect.php';

// Xử lý thêm điểm du lịch mới
if (isset($_POST['add'])) {
    $tendiemdl = $_POST['tendiemdl'];
    $diachi = $_POST['diachi'];
    $mota = $_POST['mota'];
    $giave = $_POST['giave'];
    $giophucvu = $_POST['giophucvu'];
    $matinh = $_POST['matinh'];
    $maloaihinh = $_POST['maloaihinh'];

    $sql = "INSERT INTO DiemDuLich (tendiemdl, diachi, mota, giave, giophucvu, matinh, maloaihinh) 
            VALUES ('$tendiemdl', '$diachi', '$mota', '$giave', '$giophucvu', '$matinh', '$maloaihinh')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Điểm du lịch đã được thêm thành công.";
    } else {
        $message = "Lỗi khi thêm điểm du lịch.";
    }
}

// Xử lý xóa điểm du lịch
if (isset($_GET['delete'])) {
    $madiemdl = $_GET['delete'];
    $sql = "DELETE FROM DiemDuLich WHERE madiemdl = $madiemdl";
    if (mysqli_query($conn, $sql)) {
        $message = "Điểm du lịch đã được xóa thành công.";
    } else {
        $message = "Lỗi khi xóa điểm du lịch.";
    }
}

// Xử lý sửa điểm du lịch
if (isset($_POST['edit'])) {
    $madiemdl = $_POST['madiemdl'];
    $tendiemdl = $_POST['tendiemdl'];
    $diachi = $_POST['diachi'];
    $mota = $_POST['mota'];
    $giave = $_POST['giave'];
    $giophucvu = $_POST['giophucvu'];
    $matinh = $_POST['matinh'];
    $maloaihinh = $_POST['maloaihinh'];

    $sql = "UPDATE DiemDuLich SET tendiemdl = '$tendiemdl', diachi = '$diachi', mota = '$mota', giave = '$giave', 
            giophucvu = '$giophucvu', matinh = '$matinh', maloaihinh = '$maloaihinh' WHERE madiemdl = $madiemdl";
    if (mysqli_query($conn, $sql)) {
        $message = "Điểm du lịch đã được sửa thành công.";
    } else {
        $message = "Lỗi khi sửa điểm du lịch.";
    }
}

// Lấy danh sách điểm du lịch
$sql = "SELECT * FROM DiemDuLich";
$result = mysqli_query($conn, $sql);

// Lấy danh sách tỉnh thành và loại hình cho dropdown
$sql_tinhthanh = "SELECT * FROM TinhThanh";
$tinhthanh_result = mysqli_query($conn, $sql_tinhthanh);

$sql_loaihinh = "SELECT * FROM LoaiHinh";
$loaihinh_result = mysqli_query($conn, $sql_loaihinh);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Lý Điểm Du Lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản Lý Điểm Du Lịch</h2>

        <!-- Hiển thị thông báo -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form thêm điểm du lịch mới -->
        <h3 class="mt-4">Thêm Điểm Du Lịch</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="tendiemdl" class="form-label">Tên Điểm Du Lịch</label>
                <input type="text" class="form-control" name="tendiemdl" required>
            </div>
            <div class="mb-3">
                <label for="diachi" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" name="diachi" required>
            </div>
            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control" name="mota" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="giave" class="form-label">Giá Vé</label>
                <input type="number" class="form-control" name="giave" required>
            </div>
            <div class="mb-3">
                <label for="giophucvu" class="form-label">Giờ Phục Vụ</label>
                <input type="time" class="form-control" name="giophucvu" required>
            </div>
            <div class="mb-3">
                <label for="matinh" class="form-label">Tỉnh Thành</label>
                <select name="matinh" class="form-control" required>
                    <?php while ($row = mysqli_fetch_assoc($tinhthanh_result)): ?>
                        <option value="<?php echo $row['matinh']; ?>"><?php echo $row['tentinh']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="maloaihinh" class="form-label">Loại Hình</label>
                <select name="maloaihinh" class="form-control" required>
                    <?php while ($row = mysqli_fetch_assoc($loaihinh_result)): ?>
                        <option value="<?php echo $row['maloaihinh']; ?>"><?php echo $row['tenloaihinh']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Thêm</button>
        </form>

        <!-- Danh sách điểm du lịch -->
        <h3 class="mt-4">Danh Sách Điểm Du Lịch</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mã Điểm Du Lịch</th>
                    <th scope="col">Tên Điểm Du Lịch</th>
                    <th scope="col">Địa Chỉ</th>
                    <th scope="col">Giá Vé</th>
                    <th scope="col">Giờ Phục Vụ</th>
                    <th scope="col">Tỉnh Thành</th>
                    <th scope="col">Loại Hình</th>
                    <th scope="col">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['madiemdl']; ?></td>
                        <td><?php echo $row['tendiemdl']; ?></td>
                        <td><?php echo $row['diachi']; ?></td>
                        <td><?php echo $row['giave']; ?></td>
                        <td><?php echo $row['giophucvu']; ?></td>
                        <td><?php echo $row['matinh']; ?></td>
                        <td><?php echo $row['maloaihinh']; ?></td>
                        <td>
                            <a href="QL_DiemDuLich.php?edit=<?php echo $row['madiemdl']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="QL_DiemDuLich.php?delete=<?php echo $row['madiemdl']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa điểm du lịch này không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Nếu cần sửa điểm du lịch -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $madiemdl = $_GET['edit'];
            $edit_sql = "SELECT * FROM DiemDuLich WHERE madiemdl = $madiemdl";
            $edit_result = mysqli_query($conn, $edit_sql);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>
            <h3 class="mt-4">Sửa Điểm Du Lịch</h3>
            <form method="POST">
                <input type="hidden" name="madiemdl" value="<?php echo $edit_row['madiemdl']; ?>">
                <div class="mb-3">
                    <label for="tendiemdl" class="form-label">Tên Điểm Du Lịch</label>
                    <input type="text" class="form-control" name="tendiemdl" value="<?php echo $edit_row['tendiemdl']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="diachi" class="form-label">Địa Chỉ</label>
                    <input type="text" class="form-control" name="diachi" value="<?php echo $edit_row['diachi']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mota" class="form-label">Mô Tả</label>
                    <textarea class="form-control" name="mota" rows="3" required><?php echo $edit_row['mota']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="giave" class="form-label">Giá Vé</label>
                    <input type="number" class="form-control" name="giave" value="<?php echo $edit_row['giave']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="giophucvu" class="form-label">Giờ Phục Vụ</label>
                    <input type="time" class="form-control" name="giophucvu" value="<?php echo $edit_row['giophucvu']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="matinh" class="form-label">Tỉnh Thành</label>
                    <select name="matinh" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($tinhthanh_result)): ?>
                            <option value="<?php echo $row['matinh']; ?>" <?php echo $row['matinh'] == $edit_row['matinh'] ? 'selected' : ''; ?>><?php echo $row['tentinh']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="maloaihinh" class="form-label">Loại Hình</label>
                    <select name="maloaihinh" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($loaihinh_result)): ?>
                            <option value="<?php echo $row['maloaihinh']; ?>" <?php echo $row['maloaihinh'] == $edit_row['maloaihinh'] ? 'selected' : ''; ?>><?php echo $row['tenloaihinh']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="edit" class="btn btn-primary">Cập Nhật</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
