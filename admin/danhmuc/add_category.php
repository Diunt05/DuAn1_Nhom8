<?php
require_once '../../models/env.php';
require_once '../../models/ConnectDatabase.php';

$db = new ConnectDatabase();

// Xử lý việc thêm danh mục
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_category = $_POST['name_category'] ?? '';

    // Kiểm tra dữ liệu đầu vào
    if (empty($name_category)) {
        $error = "Tên danh mục không được để trống.";
    } else {
        try {
            // Insert only name_category since id_category is auto-increment
            $db->setQuery("INSERT INTO category (name_category) VALUES (?)");
            $db->execute([$name_category]);

            // Điều hướng trở lại trang chủ sau khi thêm thành công
            header('Location: ../index.php');
            exit();
        } catch (PDOException $e) {
            $error = "Lỗi khi thêm danh mục: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh mục</title>
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
            background-color: #ff6a00;
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
            color: #ff6a00;
            text-decoration: none;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Thêm Danh mục</h1>

<?php if (isset($error)): ?>
    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST">
    <label for="name_category">Tên Danh mục:</label>
    <input type="text" name="name_category" id="name_category" required>
    
    <button type="submit">Thêm Danh mục</button>
</form>

<a href="index.php">Trở về</a>

</body>
</html>
