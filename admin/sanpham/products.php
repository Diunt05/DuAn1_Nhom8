
<?php 
include '../models/ConnectDatabase.php'; 

// Xử lý thêm sản phẩm
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $amount_product = $_POST['amount_product'];

    // Kiểm tra trạng thái
    $status_product = $amount_product > 0 ? 'Còn hàng' : 'Hết hàng';

    // Thêm sản phẩm vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO products (name_product, price_product, description_product, image_product, id_category, amount_product, status_product) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $description, $image, $category, $amount_product, $status_product]);

    header("Location: products.php");
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id_product = ?");
    $stmt->execute([$id]);
    header("Location: products.php");
}

// Xử lý sửa sản phẩm
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $amount_product = $_POST['amount_product'];

    // Kiểm tra trạng thái
    $status_product = $amount_product > 0 ? 'Còn hàng' : 'Hết hàng';

    // Cập nhật sản phẩm
    $stmt = $pdo->prepare("UPDATE products SET name_product = ?, price_product = ?, description_product = ?, image_product = ?, id_category = ?, amount_product = ?, status_product = ? WHERE id_product = ?");
    $stmt->execute([$name, $price, $description, $image, $category, $amount_product, $status_product, $id]);
    header("Location: products.php");
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h1 {
            text-align: center;
            color: #333;
            padding: 20px 0;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input, form textarea, form button {
            width: calc(100% - 40px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: block;
        }
        form button {
            width: 100%;
            color: #fff;
            background: #28a745;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background-color: #f8f9fa;
            color: #333;
        }
        table td img {
            max-width: 50px;
            height: auto;
        }
        .actions a {
            text-decoration: none;
            color: #007bff;
            margin: 0 5px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Quản lý sản phẩm</h1>

    <!-- Form thêm sản phẩm -->
   
<form action="" method="post" onsubmit="return confirm('Bạn có chắc muốn thêm sản phẩm này?');">
    <input type="text" name="name" placeholder="Tên sản phẩm" required>
    <input type="number" name="price" placeholder="Giá" required>
    <textarea name="description" placeholder="Mô tả sản phẩm" required></textarea>
    <input type="text" name="image" placeholder="Link hình ảnh" required>
    <input type="number" name="category" placeholder="Mã danh mục" required>
    <input type="number" name="amount_product" placeholder="Số lượng" required>
    <button type="submit" name="add">Thêm sản phẩm</button>
</form>


    <!-- Hiển thị danh sách sản phẩm -->
    <table>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
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
            echo "<td>" . $product['amount_product'] . "</td>";
            echo "<td>" . $product['status_product'] . "</td>";
            echo "<td class='actions'>
                    <a href='products.php?edit=" . $product['id_product'] . "'>Sửa</a> | 
                    <a href='products.php?delete=" . $product['id_product'] . "' onclick='return confirm(\"Bạn có chắc muốn xóa?\");'>Xóa</a>
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
<form action="" method="post" onsubmit="return confirm('Bạn có chắc muốn cập nhật sản phẩm này?');">
    <input type="hidden" name="id" value="<?= $product['id_product'] ?>">
    <input type="text" name="name" value="<?= $product['name_product'] ?>" required>
    <input type="number" name="price" value="<?= $product['price_product'] ?>" required>
    <textarea name="description" required><?= $product['description_product'] ?></textarea>
    <input type="text" name="image" value="<?= $product['image_product'] ?>" required>
    <input type="number" name="category" value="<?= $product['id_category'] ?>" required>
    <input type="number" name="amount_product" value="<?= $product['amount_product'] ?>" placeholder="Số lượng" required>
    <button type="submit" name="update">Cập nhật sản phẩm</button>
</form>
<?php endif; ?>

</div>

</body>
</html>
