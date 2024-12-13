<?php
$servername = "localhost"; // Địa chỉ máy chủ
$username = "root";        // Tên người dùng MySQL
$password = "";            // Mật khẩu MySQL
$dbname = "travel";        // Tên cơ sở dữ liệu

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
