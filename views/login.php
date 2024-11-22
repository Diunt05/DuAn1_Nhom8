<?php
define('BASEPATH', TRUE);
require '../models/ConnectDatabase.php'; // Kết nối tới database

session_start(); // Bắt đầu session để lưu thông tin người dùng

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email_user = $_POST['email_user'];
        $password_user = $_POST['password_user'];

        // Kiểm tra email trong cơ sở dữ liệu
        $sql = "SELECT * FROM user WHERE email_user = :email_user LIMIT 1";
        $stmt = $dsn->prepare($sql);
        $stmt->bindValue(':email_user', $email_user);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Nếu email tồn tại, kiểm tra mật khẩu
            if (password_verify($password_user, $user['password_user'])) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['user_name'] = $user['name_user'];

                // Chuyển hướng tới trang dashboard
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                // Mật khẩu không đúng
                echo '<script>alert("Mật khẩu không đúng!");</script>';
            }
        } else {
            // Email không tồn tại
            echo '<script>alert("Email không tồn tại trong hệ thống!");</script>';
        }
    } catch (PDOException $e) {
        // Lỗi kết nối hoặc xử lý
        $error = "Error: " . $e->getMessage();
        echo '<script>alert("' . $error . '");</script>';
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="../Content/login.css">
    <link rel="stylesheet" href="../Content/trangchu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">

        <div class="header-top">
            <div class="contact-info">
                <i class="fas fa-map-marker-alt"></i>
                <span>13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</span>
                <i class="fas fa-envelope"></i>
                <a href="https://caodang.fpt.edu.vn/">caodang@fpt.edu.vn</a>
            </div>
            <div class="nav-links">
                <a href="#"><i class="fas fa-truck"></i> Theo dõi đơn hàng</a>
                <a href="#">Chính sách</a>
                <a href="#">Thanh toán</a>
            </div>
        </div>

        <div class="header">
            <!-- Phần trên của header -->
            <div class="header1">
                <!-- Logo -->
                <div class="logo">
                    <img src="https://via.placeholder.com/50" alt="Logo">
                    <span>TDT SMART</span>
                </div>
        
                <!-- Thanh tìm kiếm -->
                <div class="search-bar">
                    <input type="text" placeholder="Tìm kiếm...">
                    <i class="fas fa-search"></i>
                </div>
        
                <!-- Biểu tượng mạng xã hội -->
                <div class="icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        
            <!-- Phần dưới của header -->
            <div class="header2">
                <!-- Nút danh mục -->
                <a href="#" class="btn-category">
                    <i class="fas fa-list"></i> Danh mục
                </a>
        
                <!-- Menu điều hướng -->
                <div class="menu">
                    <a href="trangchu.html" class="menu-item">Trang chủ</a>
                    <a href="gioithieu.html" class="menu-item">Giới thiệu</a>
                    <a href="sanpham.html" class="menu-item">Sản phẩm</a>
                    <a href="tintuc.html" class="menu-item">Tin tức</a>
                    <a href="lienhe.html" class="menu-item">Liên hệ</a>
                </div>
        
                <!-- Yêu thích và giỏ hàng -->
                <div class="icons">
                    <div class="icon-badge">
                        <a href="#"><i class="far fa-heart"></i></a>
                        <span class="badge">0</span>
                    </div>
                    <div class="icon-badge">
                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                        <span class="badge">0</span>
                    </div>

                    <!-- <div class="icon-badge hi">
                        <a href="#"><i class="fa-regular fa-user"></i></a>
                        <a href="#"><p>Đăng nhập</p></a>
                    </div> -->
                </div>
            </div>
        </div>
    </header>

    <div class="login-container">
        <!-- Logo -->
        <div class="logo">TDT Smart</div>

        <!-- Tiêu đề -->
        <div class="login-title">Đăng nhập vào tài khoản của bạn</div>

        <!-- Form đăng nhập -->
        <form action="login.php" method="POST">
            <!-- Nhập tài khoản -->
            <input type="text" class="input-field" name="email_user" placeholder="Email hoặc Số điện thoại" required>

            <!-- Nhập mật khẩu -->
            <input type="password" class="input-field" name="password_user" placeholder="Mật khẩu" required>

            <!-- Nút đăng nhập -->
            <button type="submit" class="login-button">Đăng nhập</button>
        </form>

        <!-- Link quên mật khẩu và đăng ký -->
        <div class="login-links">
            <a href="#">Quên mật khẩu?</a>
            <a href="./register.php">Đăng ký tài khoản</a>
        </div>
    </div>

    <br>
    <div class="container-12">
        <!-- Footer -->
        <footer
                class="text-center text-lg-start text-dark"
                style="background-color: #ECEFF1"
                >
            <!-- Section: Social media -->
            <section
                    class="d-flex justify-content-between p-4 text-white"
                    style="background-color: #f27e2c"
                    >
            <!-- Left -->
            <div class="me-5">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->
        
            <!-- Right -->
            <div>
                <a href="" class="text-white me-4">
                <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="text-white me-4">
                <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="text-white me-4">
                <i class="fab fa-google"></i>
                </a>
                <a href="" class="text-white me-4">
                <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="text-white me-4">
                <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="text-white me-4">
                <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
            </section>
            <!-- Section: Social media -->
        
            <!-- Section: Links  -->
            <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold">Company name</h6>
                    <hr
                        class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px"
                        />
                    <p>
                    Hãy khám phá bộ sưu tập sản phẩm công nghệ của chúng tôi ngay hôm nay và trải nghiệm mua sắm trực tuyến tuyệt vời
                    tại trang chủ của chúng tôi.
                    </p>
                </div>
                <!-- Grid column -->
        
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Products</h6>
                    <hr
                        class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px"
                        />
                    <p>
                    <a href="#!" class="text-dark">MDBootstrap</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">MDWordPress</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">BrandFlow</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">Bootstrap Angular</a>
                    </p>
                </div>
                <!-- Grid column -->
        
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Useful links</h6>
                    <hr
                        class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px"
                        />
                    <p>
                    <a href="#!" class="text-dark">Your Account</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">Become an Affiliate</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">Shipping Rates</a>
                    </p>
                    <p>
                    <a href="#!" class="text-dark">Help</a>
                    </p>
                </div>
                <!-- Grid column -->
        
                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Contact</h6>
                    <hr
                        class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px"
                        />
                    <p><i class="fas fa-home mr-3"></i> 13 P. Trịnh Văn Bô, Xuân Phương, NTL, HN.</p>
                    <p><i class="fas fa-envelope mr-3"></i> info@example.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                </div>
                <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
            </section>
            <!-- Section: Links  -->
        
            <!-- Copyright -->
            <div
                class="text-center p-3"
                style="background-color: rgba(0, 0, 0, 0.2)"
                >
            © 2020 Copyright:
            <a class="text-dark" href="https://mdbootstrap.com/"
                >MDBootstrap.com</a
                >
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </div>

    
</body>
</html>
    