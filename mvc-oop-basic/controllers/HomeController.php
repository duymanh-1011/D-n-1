<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }
    public function home(){
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }

     public function chiTietSanPham(){
        $id = $_GET['id_san_pham'];

        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);

        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);

        // var_dump($listSanPhamCungDanhMuc);die;
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }

     public function formLogin(){
        require_once './views/auth/formLogin.php';
        exit();
    }

    public function formRegister(){
        require_once './views/auth/formRegister.php';
        exit();
    }

    public function postRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ho_ten = trim($_POST['ho_ten']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = [];
            if (!$ho_ten || !$email || !$password || !$password_confirm) {
                $errors[] = 'Vui lòng điền đầy đủ thông tin.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ.';
            }
            if ($password !== $password_confirm) {
                $errors[] = 'Mật khẩu xác nhận không khớp.';
            }
            if ($this->modelTaiKhoan->getTaiKhoanFromEmail($email)) {
                $errors[] = 'Email đã tồn tại, vui lòng dùng email khác.';
            }

            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header('Location: ' . BASE_URL . '?act=register');
                exit();
            }

            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $this->modelTaiKhoan->addTaiKhoan($ho_ten, $email, $hashedPass);

            $_SESSION['user_client'] = $email;
            header('Location: ' . BASE_URL);
            exit();
        }
    }

    public function logout(){
        unset($_SESSION['user_client']);
        header("Location: " . BASE_URL . '?act=login');
        exit();
    }

    public function postLogin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // lấy email và pass gửi lên từ form 
            $email = $_POST['email'];
            $password = $_POST['password'];

            // var_dump($email);die;

            // Xử lý kiểm tra thông tin đăng nhập

            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($user == $email) { // Trường hợp đăng nhập thành công
                // Lưu thông tin vào session 
                $_SESSION['user_client'] = $user;
                header("Location: " . BASE_URL);
                exit();
            }else{
                // Lỗi thì lưu lỗi vào session
                $_SESSION['error'] = $user;
                // var_dump($_SESSION['error']);die;

                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL . '?act=login');
                exit();
                
            }
        }
    }

    public function addGioHang(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user_client'])) {
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
                // Lấy dữ liệu giỏ hàng của người dùng
                
                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id'=>$gioHangId];
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                }else{
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                }

                $san_pham_id = $_POST['san_pham_id'];
                $so_luong = $_POST['so_luong'];

                $checkSanPham = false;
                foreach($chiTietGioHang as $detail){
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }
                if(!$checkSanPham){
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
                }
                header("Location:" . BASE_URL . '?act=gio-hang');
            }else{
                var_dump('Chưa đăng nhập');die;
            }
            

            
            
        }
    }

    public function gioHang(){
        if (isset($_SESSION['user_client'])) {
            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            // Lấy dữ liệu giỏ hàng của người dùng
            
            $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                $gioHang = ['id'=>$gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }else{
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            // var_dump($chiTietGioHang);die;

            require_once './views/gioHang.php';

        }else{
            header("Location: ". BASE_URL . '?act=login');
        }
    }

    public function thanhToan(){
        if (isset($_SESSION['user_client'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            // Lấy dữ liệu giỏ hàng của người dùng
            
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id'=>$gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }else{
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            // var_dump($chiTietGioHang);die;

            require_once './views/thanhToan.php';

        }else{
            var_dump('Chưa đăng nhập');die;
        }                               
                                            
        
    }

    public function checkLoginCart() {
    if (!isset($_SESSION['user_client'])) {
        $_SESSION['error'] = ['Bạn chưa đăng nhập!'];

        session_write_close(); 

        header("Location: " . BASE_URL . '?act=login');
        exit();
        }
    }

    public function updateCart() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $san_pham_id = $_POST['san_pham_id'];
        $so_luong = $_POST['so_luong'];
        $action = $_POST['action'];

        $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
        $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);

        if ($action == 'plus') {
            $so_luong++;
        } else {
            $so_luong--;
            if ($so_luong < 1) $so_luong = 1;
        }

        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $so_luong);

        header("Location: " . BASE_URL . '?act=gio-hang');
        exit();
    }
}

    public function postThanhToan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;
            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
            $ghi_chu = $_POST['ghi_chu'];
            $tong_tien = $_POST['tong_tien'];
            $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

            $ngay_dat = date('Y-m-d');
            $trang_thai_id = 1;

            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            // Kiểm tra giỏ hàng trống
            $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
            $chiTietGioHang = $gioHang ? $this->modelGioHang->getDetailGioHang($gioHang['id']) : [];
            if (empty($gioHang) || empty($chiTietGioHang)) {
                $_SESSION['error'] = ['Giỏ hàng trống, vui lòng chọn sản phẩm trước khi thanh toán'];
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }

            $ma_don_hang = 'DH-' . rand(1000,9999);

            $donhang = $this->modelDonHang->addDonHang($tai_khoan_id,
                                            $ten_nguoi_nhan,
                                            $email_nguoi_nhan,
                                            $sdt_nguoi_nhan,
                                            $dia_chi_nguoi_nhan,
                                            $ghi_chu,
                                            $tong_tien,
                                            $phuong_thuc_thanh_toan_id,
                                            $ngay_dat,
                                            $ma_don_hang,
                                            $trang_thai_id
            );
            if ($donhang) {
                // Lấy ra sản phẩm trong giỏ hàng hiện tại
                $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

                // Lưu từng sản phẩm vào chi tiết đơn hàng
                foreach ($chiTietGioHang as $item) {
                    $donGia = $item['gia_khuyen_mai'] ?? $item['gia_san_pham'];
                    $this->modelDonHang->addChiTietDonHang(
                        $donhang,
                        $item['san_pham_id'],
                        $donGia,
                        $item['so_luong'],
                        $donGia * $item['so_luong']
                    );
                }

                $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                $this->modelGioHang->clearGioHang($tai_khoan_id);

                // Chuyển hướng về lịch sử mua hàng
                header("Location: " . BASE_URL . '?act=lich_su_mua_hang');
                exit();
            } else {
                echo "Đặt hàng thất bại. Vui lòng thử lại.";
            } 
        } 
    }
     public function lichSuMuaHang()
    {
        if (isset($_SESSION['user_client'])) {
            // Lấy ra thông tin tài khoản đăng nhập theo email (session lưu chuỗi email)
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            // Lấy ra danh sách trạng thái đơn hàng
            $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaIDonHang();
            $trangThaiDonHang = array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');


            // Lấy ra danh sách phương thức thanh toán
            $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan = array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');


            // Lấy ra danh sách tất cả trạng thái của tài khoản
            $donHangs = $this->modelDonHang->getDonHangFromUser($tai_khoan_id);
            require_once "./views/lichSuMuaHang.php";
        } else {
            var_dump("Ban chua dang nhap");
            die;
        }
    }
    public function chiTietMuaHang()
    {
        if (isset($_SESSION['user_client'])) {
            // Lấy ra thông tin tài khoản đăng nhập theo email (session lưu chuỗi email)
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            // Lấy id đơn hàng truyền từ URL
            $donHangId = $_GET['id'];


            // Lấy ra danh sách trạng thái đơn hàng
            $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaIDonHang();
            $trangThaiDonHang = array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');


            // Lấy ra danh sách phương thức thanh toán
            $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan = array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');

            // Lấy ra thông tin đơn hàng theo ID
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            // Lấy thông tin sản phẩm của đơn hàng trong bảng chi tiết đơn hàng
            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);


            if ($donHang['tai_khoan_id'] != $tai_khoan_id) {
                echo "Bạn không có quyền truy cập đơn hàng này.";
                exit;
            }

            require_once './views/chiTietMuaHang.php';
        } else {
            var_dump("Ban chua dang nhap");
            die;
        }
    }
    public function huyDonHang()
    {
        if (isset($_SESSION['user_client'])) {
            // Lấy ra thông tin tài khoản đăng nhập theo email (session lưu chuỗi email)
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            // Lấy id đơn hàng truyền từ URL
            $donHangId = $_GET['id'];


            // Kiểm tra đơn hàng
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            if ($donHang['tai_khoan_id'] != $tai_khoan_id) {
                echo "Bạn không có quyền hủy đơn hàng này";
                exit;
            }
            if ($donHang['trang_thai_id'] != 1) {
                echo "Chỉ đơn hàng ở trạng thái 'Chưa xác nhận' mới có thể hủy";
                exit;
            }


            // Hủy đơn hàng
            $this->modelDonHang->updateTrangThaiDonHang($donHangId, 11);
            header("Location: " . BASE_URL . '?act=lich_su_mua_hang');
            exit();


            // Lấy ra danh sách tất cả trạng thái của tài khoản
            $donHangs = $this->modelDonHang->getDonHangFromUser($tai_khoan_id);
            require_once "./views/lichSuMuaHang.php";
        } else {
            var_dump("Ban chua dang nhap");
            die;
        }
    }
}
