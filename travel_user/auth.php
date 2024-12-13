<?php
session_start();
include('D:\XAMPP\htdocs\travel\travel_user\db_connect.php'); // Đảm bảo đường dẫn đúng
$query = "SELECT * FROM users WHERE role = 'admin'";
$result = mysqli_query($conn, $query);

// Nếu không có tài khoản admin nào
if (mysqli_num_rows($result) == 0) {
    // Tạo tài khoản admin mặc định
    $admin_username = 'admin';
    $admin_password = password_hash('admin_password', PASSWORD_DEFAULT); // Mật khẩu đã mã hóa
    $admin_role = 'admin';

    // Thêm tài khoản admin vào cơ sở dữ liệu
    $insert_query = "INSERT INTO users (username, password, role) VALUES ('$admin_username', '$admin_password', '$admin_role')";
    if (mysqli_query($conn, $insert_query)) {
        echo "Tài khoản admin mặc định đã được tạo thành công.";
    } else {
        echo "Lỗi khi tạo tài khoản admin mặc định.";
    }
}

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location:  index.php");
    } else {
        header("Location:  index.php");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin vào session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Chuyển hướng dựa trên role
            if ($_SESSION['role'] == 'admin') {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Sai mật khẩu
            $_SESSION['error_message'] = "Sai mật khẩu.";
        }
    } else {
        // Tài khoản không tồn tại
        $_SESSION['error_message'] = "Tài khoản không tồn tại.";
    }

    // Chuyển hướng về login nếu lỗi
    header("Location: login.php");
    exit();
}
?>
