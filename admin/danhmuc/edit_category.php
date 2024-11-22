<?php
require_once '../../models/env.php';
require_once '../../models/ConnectDatabase.php';
$db = new ConnectDatabase();

// Tải danh mục cần chỉnh sửa
$id_category = $_GET['id_category'] ?? null;
$category = null;

if ($id_category) {
    $db->setQuery("SELECT * FROM category WHERE id_category = ?");
    $category = $db->loadData([$id_category], false);
}

// Xử lý việc chỉnh sửa danh mục
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_category = $_POST['name_category'] ?? '';
    $id_category = $_POST['id_category'] ?? '';

    // Kiểm tra dữ liệu đầu vào
    if (empty($name_category) || empty($id_category)) {
        $error = "Tên danh mục và URL hình ảnh không được để trống.";
    } else {
        try {
            // Cập nhật danh mục
            $db->setQuery("UPDATE category SET name_category = ? WHERE id_category = ?");
            $db->execute([$name_category, $id_category]);

            // Chuyển hướng về trang chính
            header('Location: ../index.php');
            exit();
        } catch (PDOException $e) {
            $error = "Lỗi khi cập nhật danh mục: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Danh mục</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }
        form {
            background-color: #fff;
            width: 50%;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        a {
            display: block;
            text-align: center;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Sửa Danh mục</h1>

<?php if (isset($error)): ?>
    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if ($category): ?>
    <form method="POST">
        <label for="id_category">ID Danh Mục</label>
        <input type="text" name="id_category" id="id_category" readonly value="<?php echo htmlspecialchars($category->id_category); ?>" required>
        
        <label for="name_category">Tên danh mục:</label>
        <input type="text" name="name_category" id="name_category" value="<?php echo htmlspecialchars($category->name_category); ?>" required>
        
        <button type="submit">Cập nhật Danh mục</button>
    </form>
<?php else: ?>
    <p>Danh mục không tồn tại.</p>
<?php endif; ?>

<a href="index.php">Trở về</a>

</body>
</html>
