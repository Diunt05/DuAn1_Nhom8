<?php 
include '../models/ConnectDatabase.php'; 

// Xử lý thêm sản phẩm
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("INSERT INTO products (name_product, price_product, description_product, image_product, id_category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $description, $image, $category]);
    header("Location: quanly_sanpham.php");
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id_product = ?");
    $stmt->execute([$id]);
    header("Location: quanly_sanpham.php");
}

// Xử lý sửa sản phẩm
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE products SET name_product = ?, price_product = ?, description_product = ?, image_product = ?, id_category = ? WHERE id_product = ?");
    $stmt->execute([$name, $price, $description, $image, $category, $id]);
    header("Location: quanly_sanpham.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="sanpham.css">
</head>
<body>
    <h1>Quản lý sản phẩm</h1>

    <!-- Form thêm sản phẩm -->
    <form action="" method="post">
        <input type="text" name="name" placeholder="Tên sản phẩm" required>
        <input type="number" name="price" placeholder="Giá" required>
        <textarea name="description" placeholder="Mô tả sản phẩm" required></textarea>
        <input type="text" name="image" placeholder="Link hình ảnh" required>
        <input type="number" name="category" placeholder="Mã danh mục" required>
        <button type="submit" name="add">Thêm sản phẩm</button>
    </form>

    <hr>

    <!-- Hiển thị danh sách sản phẩm -->
    <table>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();

        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['id_product'] . "</td>";
            echo "<td>" . $product['name_product'] . "</td>";
            echo "<td>" . number_format($product['price_product'], 0, ',', '.') . " VND</td>";
            echo "<td>" . $product['description_product'] . "</td>";
            echo "<td><img src='" . $product['image_product'] . "' width='50'></td>";
            echo "<td>" . $product['id_category'] . "</td>";
            echo "<td>
                    <a href='quanly_sanpham.php?edit=" . $product['id_product'] . "'>Sửa</a> | 
                    <a href='quanly_sanpham.php?delete=" . $product['id_product'] . "' onclick='return confirm(\"Bạn có chắc muốn xóa?\");'>Xóa</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id_product = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
    ?>
    <!-- Form sửa sản phẩm -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $product['id_product'] ?>">
        <input type="text" name="name" value="<?= $product['name_product'] ?>" required>
        <input type="number" name="price" value="<?= $product['price_product'] ?>" required>
        <textarea name="description" required><?= $product['description_product'] ?></textarea>
        <input type="text" name="image" value="<?= $product['image_product'] ?>" required>
        <input type="number" name="category" value="<?= $product['id_category'] ?>" required>
        <button type="submit" name="update">Cập nhật sản phẩm</button>
    </form>
    <?php endif; ?>
</body>
</html>
