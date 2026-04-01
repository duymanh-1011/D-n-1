<?php
session_start();
// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/Student.php';
require_once './models/SanPham.php';
require_once './models/TaiKhoanClient.php';
require_once './models/GioHangClient.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    '/', '', 'home' => (new HomeController())->home(),
    'trangchu' => (new HomeController())->trangchu(),
    'gioi-thieu' => (new HomeController())->gioiThieu(),
    'lien-he' => (new HomeController())->lienHe(),
    'login' => (new HomeController())->formLoginClient(),
    'check-login-client' => (new HomeController())->loginClient(),
    'logout-client' => (new HomeController())->logoutClient(),
    'gio-hang' => (new HomeController())->gioHang(),
    'them-gio-hang' => (new HomeController())->themGioHang(),
    'cap-nhat-gio-hang' => (new HomeController())->capNhatGioHang(),
    'xoa-gio-hang' => (new HomeController())->xoaGioHang(),
    'thanh-toan' => (new HomeController())->thanhToan(),
    'xu-ly-thanh-toan' => (new HomeController())->postThanhToan(),
    'lich-su-mua-hang' => (new HomeController())->lichSuMuaHang(),
    'chi-tiet-don-hang' => (new HomeController())->chiTietDonHang(),
    'huy-don-hang' => (new HomeController())->huyDonHang(),
    'danh-sach-san-pham' => (new HomeController())->danhSachSanPham(),
    'chi-tiet-san-pham' => (new HomeController())->chiTietSanPham(),
    default => (new HomeController())->home(),
};
