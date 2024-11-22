<?php
session_start();

$user = '';

if (!isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chu</title>
</head>
<body>
    <h1>Xin chào <?php echo $user; ?></h1>
</body>
</html>

<!-- // Hiển thị thông tin người dùng
echo "Xin chào, " . htmlspecialchars($_SESSION['user']['name_user']) . "! Bạn đã đăng nhập thành công.";
echo "<br><a href='logout.php'>Đăng xuất</a>"; -->
