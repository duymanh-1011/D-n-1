<?php
session_start();
// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';
require_once './models/GioHang.php';
require_once './models/DonHang.php';

// Route
$act = $_GET['act'] ?? '/';
// var_dump($_GET['act'] ?? '/');

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    '/' => (new HomeController())->home(), // route trang chủ

    // Auth
    'login' => (new HomeController())->formLogin(),
    'register-form' => (new HomeController())->formRegister(),
    'check-register' => (new HomeController())->postRegister(),
    'check-login' => (new HomeController())->postLogin(),
    'logout' => (new HomeController())->logout(),

    'danh-sach-san-pham' => (new HomeController())->danhSachSanPham(),
    'chi-tiet-san-pham' => (new HomeController())->chiTietSanPham(),
    'post-binh-luan' => (new HomeController())->postBinhLuan(),
    'them-gio-hang' =>(new HomeController())->addGioHang(),
    'gio-hang' =>(new HomeController())->gioHang(),
    'thanh-toan' =>(new HomeController())->thanhToan(),
    'xu-ly-thanh-toan' =>(new HomeController())->postThanhToan(),
    'update-cart' =>(new HomeController())->updateCart(),
    'check-login-cart' =>(new HomeController())->checkLoginCart(),
    'lich_su_mua_hang' => (new HomeController())->lichSuMuaHang(),
    'chi_tiet_mua_hang' => (new HomeController())->chiTietMuaHang(),
    'huy_don_hang' => (new HomeController())->huyDonHang(),
    'gioi-thieu' => (new HomeController())->gioiThieu(),
    'lien-he' => (new HomeController())->lienHe(),
    'tai-khoan' => (new HomeController())->taiKhoan(),
};
