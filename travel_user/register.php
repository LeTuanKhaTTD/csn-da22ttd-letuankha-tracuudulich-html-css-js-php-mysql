<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center my-5">Đăng Ký Tài Khoản</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include('db_connect.php');

            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = 'user';

            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<div class='alert alert-danger'>Tên người dùng đã tồn tại.</div>";
            } else {
                // Thêm người dùng mới vào cơ sở dữ liệu
                $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "<div class='alert alert-success'>Đăng ký thành công. <a href='login.php'>Đăng nhập ngay</a></div>";
                } else {
                    echo "<div class='alert alert-danger'>Đăng ký thất bại. Vui lòng thử lại.</div>";
                }
            }
        }
        ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Tên người dùng</label>
                <input type="text" class="form-control" name="username" placeholder="Tên người dùng" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
        </form>
    </div>
</body>
</html>
