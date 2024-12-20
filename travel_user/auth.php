<?php
session_start();
include('db_connect.php'); 

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../travel_admin/index_ad.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

// Tạo tài khoản admin mặc định nếu chưa có trong cơ sở dữ liệu
$query = "SELECT * FROM users WHERE role = 'admin' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // Tạo tài khoản admin mặc định
    $admin_username = 'admin';
    $admin_password = password_hash('admin_password', PASSWORD_DEFAULT); 
    $admin_role = 'admin';

    $insert_query = "INSERT INTO users (username, password, role) VALUES ('$admin_username', '$admin_password', '$admin_role')";
    if (mysqli_query($conn, $insert_query)) {
        echo "Tài khoản admin mặc định đã được tạo thành công.";
    } else {
        echo "Lỗi khi tạo tài khoản admin mặc định.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra tài khoản người dùng
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
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
                header("Location: ../travel_admin/index_ad.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Sai mật khẩu.";
        }
    } else {
        $_SESSION['error_message'] = "Tài khoản không tồn tại.";
    }

    // Chuyển hướng về login nếu có lỗi
    header("Location: login.php");
    exit();
}
?>
