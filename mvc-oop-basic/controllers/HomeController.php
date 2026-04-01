<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoanClient;
    public $modelGioHang;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoanClient = new TaiKhoanClient();
        $this->modelGioHang = new GioHangClient();
    }

    public function home()
    {
        $listSanpham = $this->modelSanPham->getAllSanPham();
        require_once __DIR__ . '/../views/home.php';
    }
    public function trangchu()
    {
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham()
    {
        $listProduct = $this->modelSanPham->getAllProduct();
        require_once __DIR__ . '/../views/listProduct.php';
    }

    public function chiTietSanPham()
    {
        $idSanPham = isset($_GET['id_san_pham']) ? (int)$_GET['id_san_pham'] : 0;
        $sanPham = null;
        $listLienQuan = [];
        $listBinhLuan = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $idSanPham > 0) {
            $noiDung = trim((string)($_POST['noi_dung'] ?? ''));

            if (empty($_SESSION['user_client'])) {
                $_SESSION['error'] = 'Vui lòng đăng nhập để bình luận';
                $_SESSION['flash'] = true;
                $redirectUrl = BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $idSanPham . '#tab_binh_luan';
                header('Location: ' . BASE_URL . '?act=login&redirect=' . rawurlencode($redirectUrl));
                exit();
            }

            if ($noiDung !== '') {
                $taiKhoanId = (int)($_SESSION['user_client']['id'] ?? 0);

                if ($taiKhoanId > 0) {
                    $this->modelSanPham->insertBinhLuan($taiKhoanId, $idSanPham, $noiDung);
                }
            }

            header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $idSanPham . '#tab_binh_luan');
            exit();
        }

        if ($idSanPham > 0) {
            $sanPham = $this->modelSanPham->getDetailSanPham($idSanPham);
            $listBinhLuan = $this->modelSanPham->getBinhLuanBySanPham($idSanPham);
        }

        if (!empty($sanPham)) {
            $listLienQuan = array_filter(
                $this->modelSanPham->getAllSanPham(),
                function ($item) use ($idSanPham) {
                    return (int)($item['id'] ?? 0) !== $idSanPham;
                }
            );
            $listLienQuan = array_slice(array_values($listLienQuan), 0, 4);
        }

        require_once __DIR__ . '/../views/detailProduct.php';
    }

    public function formLoginClient()
    {
        if (!empty($_SESSION['user_client'])) {
            $redirect = $this->safeRedirect($_GET['redirect'] ?? '');
            header('Location: ' . $redirect);
            exit();
        }

        require_once __DIR__ . '/../views/loginClient.php';
        deleteSessionError();
        exit();
    }

    public function loginClient()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }

        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $redirect = $this->safeRedirect($_POST['redirect'] ?? '');

        $_SESSION['login_old_email'] = $email;

        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin đăng nhập';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=login&redirect=' . rawurlencode($redirect));
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không đúng định dạng';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=login&redirect=' . rawurlencode($redirect));
            exit();
        }

        $result = $this->modelTaiKhoanClient->checkLogin($email, $password);

        if (!empty($result['success'])) {
            $_SESSION['user_client'] = $result['user'];
            unset($_SESSION['login_old_email']);
            header('Location: ' . $redirect);
            exit();
        }

        $_SESSION['error'] = $result['message'] ?? 'Đăng nhập thất bại';
        $_SESSION['flash'] = true;
        header('Location: ' . BASE_URL . '?act=login&redirect=' . rawurlencode($redirect));
        exit();
    }

    public function logoutClient()
    {
        if (isset($_SESSION['user_client'])) {
            unset($_SESSION['user_client']);
        }

        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    public function gioHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=gio-hang');
        $gioHang = $this->modelGioHang->getGioHangFromUser($taiKhoanId);
        $chiTietGioHang = [];

        if (!empty($gioHang['id'])) {
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang((int)$gioHang['id']);
        }

        require_once __DIR__ . '/../views/gioHang.php';
        deleteSessionError();
        exit();
    }

    public function themGioHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=gio-hang');
        $sanPhamId = (int)($_POST['san_pham_id'] ?? $_GET['id_san_pham'] ?? 0);
        $soLuong = (int)($_POST['so_luong'] ?? 1);

        if ($sanPhamId <= 0) {
            $_SESSION['error'] = 'Sản phẩm không hợp lệ';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=danh-sach-san-pham');
            exit();
        }

        $result = $this->modelGioHang->addToCart($taiKhoanId, $sanPhamId, $soLuong);
        if (empty($result['success'])) {
            $_SESSION['error'] = $result['message'] ?? 'Không thể thêm vào giỏ hàng';
            $_SESSION['flash'] = true;
        }

        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    public function capNhatGioHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=gio-hang');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['so_luong']) && is_array($_POST['so_luong'])) {
            foreach ($_POST['so_luong'] as $chiTietId => $soLuong) {
                $this->modelGioHang->updateItemQuantity($taiKhoanId, (int)$chiTietId, (int)$soLuong);
            }
        }

        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    public function xoaGioHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=gio-hang');
        $chiTietId = (int)($_GET['chi_tiet_id'] ?? 0);

        if ($chiTietId > 0) {
            $this->modelGioHang->removeItem($taiKhoanId, $chiTietId);
        }

        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    public function thanhToan()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=thanh-toan');
        $user = $this->modelTaiKhoanClient->getTaiKhoanById($taiKhoanId);

        $gioHang = $this->modelGioHang->getGioHangFromUser($taiKhoanId);
        $chiTietGioHang = [];

        if (!empty($gioHang['id'])) {
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang((int)$gioHang['id']);
        }

        if (empty($chiTietGioHang)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }

        require_once __DIR__ . '/../views/thanhToan.php';
        deleteSessionError();
        exit();
    }

    public function postThanhToan()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=thanh-toan');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit();
        }

        $payload = [
            'ten_nguoi_nhan' => trim((string)($_POST['ten_nguoi_nhan'] ?? '')),
            'email_nguoi_nhan' => trim((string)($_POST['email_nguoi_nhan'] ?? '')),
            'sdt_nguoi_nhan' => trim((string)($_POST['sdt_nguoi_nhan'] ?? '')),
            'dia_chi_nguoi_nhan' => trim((string)($_POST['dia_chi_nguoi_nhan'] ?? '')),
            'ghi_chu' => trim((string)($_POST['ghi_chu'] ?? '')),
            'phuong_thuc_thanh_toan_id' => (int)($_POST['phuong_thuc_thanh_toan_id'] ?? 1),
        ];

        if ($payload['ten_nguoi_nhan'] === '' || $payload['email_nguoi_nhan'] === '' || $payload['sdt_nguoi_nhan'] === '' || $payload['dia_chi_nguoi_nhan'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin người nhận';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit();
        }

        if (!filter_var($payload['email_nguoi_nhan'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email người nhận không hợp lệ';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit();
        }

        if (!in_array($payload['phuong_thuc_thanh_toan_id'], [1, 2], true)) {
            $payload['phuong_thuc_thanh_toan_id'] = 1;
        }

        $result = $this->modelGioHang->createOrderFromCart($taiKhoanId, $payload);

        if (empty($result['success'])) {
            $_SESSION['error'] = $result['message'] ?? 'Không thể đặt hàng';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit();
        }

        $_SESSION['error'] = 'Đặt hàng thành công. Mã đơn hàng: ' . $result['ma_don_hang'];
        $_SESSION['flash'] = true;
        header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
        exit();
    }

    public function lichSuMuaHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=lich-su-mua-hang');
        $listDonHang = $this->modelGioHang->getOrderHistoryByUser($taiKhoanId);

        require_once __DIR__ . '/../views/lichSuMuaHang.php';
        deleteSessionError();
        exit();
    }

    public function chiTietDonHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=lich-su-mua-hang');
        $donHangId = (int)($_GET['id_don_hang'] ?? 0);

        if ($donHangId <= 0) {
            $_SESSION['error'] = 'Đơn hàng không hợp lệ';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        $donHang = $this->modelGioHang->getOrderDetailByUser($taiKhoanId, $donHangId);
        if (!$donHang) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        $listSanPhamDonHang = $this->modelGioHang->getOrderItems($donHangId);
        require_once __DIR__ . '/../views/chiTietDonHang.php';
        deleteSessionError();
        exit();
    }

    public function huyDonHang()
    {
        $taiKhoanId = (int)$this->requireClientLogin(BASE_URL . '?act=lich-su-mua-hang');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        $donHangId = (int)($_POST['id_don_hang'] ?? 0);
        $lyDoHuy = trim((string)($_POST['ly_do_huy'] ?? ''));

        if ($donHangId <= 0) {
            $_SESSION['error'] = 'Đơn hàng không hợp lệ';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        $result = $this->modelGioHang->cancelOrderByUser($taiKhoanId, $donHangId, $lyDoHuy);
        $_SESSION['error'] = !empty($result['success']) ? 'Hủy đơn hàng thành công' : ($result['message'] ?? 'Không thể hủy đơn hàng');
        $_SESSION['flash'] = true;

        header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
        exit();
    }

    private function requireClientLogin($redirect)
    {
        $taiKhoanId = (int)($_SESSION['user_client']['id'] ?? 0);
        if ($taiKhoanId <= 0) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục';
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=login&redirect=' . rawurlencode($redirect));
            exit();
        }

        return $taiKhoanId;
    }

    public function gioiThieu()
    {
        require_once __DIR__ . '/../views/gioiThieu.php';
        exit();
    }

    public function lienHe()
    {
        require_once __DIR__ . '/../views/lienHe.php';
        exit();
    }

    private function safeRedirect($redirect)
    {
        $redirect = trim((string)$redirect);

        if ($redirect === '') {
            return BASE_URL;
        }

        if (str_starts_with($redirect, BASE_URL)) {
            return $redirect;
        }

        return BASE_URL;
    }
}
