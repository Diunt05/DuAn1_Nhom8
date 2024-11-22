<?php
require_once '../../models/ConnectDatabase.php';


$db = new ConnectDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy ID của danh mục cần xóa
    $id_category = $_POST['id_category'] ?? null;

    if ($id_category) {
        // Xóa danh mục từ cơ sở dữ liệu
        $db->setQuery("DELETE FROM category WHERE id_category = ?");
        $db->execute([$id_category]);
    }

    // Chuyển hướng về trang quản lý danh mục sau khi xóa
    header('Location: ../index.php');
    exit();
}
?>
