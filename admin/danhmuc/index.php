<?php
require_once '../models/ConnectDatabase.php';

// $db = new ./models/ConnectDatabase();

// Tải danh sách danh mục
$db->setQuery("SELECT * FROM category");
$categories = $db->loadData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}
h1 {
    text-align: center;
    margin-top: 20px;
    color: #333;
}
a {
    color: red;
    text-decoration: none;
    font-size: 16px;
    margin-left: 20px;
}
a:hover {
    text-decoration: underline;
}
table {
    width: 80%;
    margin: 30px auto;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}
th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th {
    background-color: #ff6a00;
    color: white;
    font-size: 16px;
}
td {
    color: #333;
}
tr:hover {
    background-color: #f1f1f1;
}
.action-buttons {
    display: flex;
    justify-content: flex-end; /* Căn chỉnh nút về bên phải */
    gap: 10px;
}
.action-buttons a, .action-buttons button {
    display: inline-block;
    width: 80px; /* Chiều rộng cố định */
    height: 35px; /* Chiều cao cố định */
    line-height: 35px; /* Căn giữa chữ theo chiều dọc */
    text-align: center;
    font-size: 14px;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}
.action-buttons a {
    background-color: #28a745; /* Màu xanh lá cho nút "Sửa" */
    border: none;
}
.action-buttons a:hover {
    background-color: #218838; /* Đổi màu khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}
.action-buttons button {
    background-color: #dc3545; /* Màu đỏ cho nút "Xóa" */
    border: none;
    padding: 0;
}
.action-buttons button:hover {
    background-color: #c82333; /* Đổi màu khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

    </style>
    <script>
        // Hàm xác nhận xóa
        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xóa danh mục này?');
        }
    </script>
</head>
<body>

<h1>Quản lý Danh mục</h1>

<a href="./view/add_category.php" >Thêm Danh mục</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category->id_category); ?></td>
                <td><?php echo htmlspecialchars($category->name_category); ?></td>
                <td class="action-buttons">
                    <a href="./view/edit_category.php?id_category=<?php echo $category->id_category; ?>">Sửa</a>
                    <form method="POST" action="./view/delete_category.php" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id_category" value="<?php echo $category->id_category; ?>">
                        <button type="submit" name="delete">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
