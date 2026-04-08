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

    public function danhSachSanPham(){
        $danh_muc_id = $_GET['danh_muc_id'] ?? null;
        $min_price = $_GET['min_price'] ?? null;
        $max_price = $_GET['max_price'] ?? null;

        $listDanhMuc = $this->modelSanPham->getAllDanhMuc();
        $listSanPham = $this->modelSanPham->getSanPhamByFilter($danh_muc_id, $min_price, $max_price);

        require_once './views/danhSachSanPham.php';
    }

    public function timKiem(){
        $keyword = trim($_GET['q'] ?? '');
        if (empty($keyword)) {
            header("Location: " . BASE_URL);
            exit();
        }

        $product = $this->modelSanPham->findProductByName($keyword);
        if ($product) {
            header("Location: " . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $product['id']);
            exit();
        }

        $category = $this->modelSanPham->findCategoryByName($keyword);
        if ($category) {
            $productInCategory = $this->modelSanPham->getFirstProductByCategory($category['id']);
            if ($productInCategory) {
                header("Location: " . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $productInCategory['id']);
                exit();
            }
        }

        // Không tìm thấy kết quả, hiển thị thông báo trên trang chủ
        $_SESSION['error'] = ['Không tìm thấy sản phẩm/ danh mục trùng khớp'];
        header("Location: " . BASE_URL);
        exit();
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

    public function postBinhLuan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_client'])) {
                $_SESSION['error'] = ['Bạn cần đăng nhập để bình luận'];
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }

            $san_pham_id = $_POST['san_pham_id'];
            $noi_dung = trim($_POST['noi_dung']);

            if (empty($noi_dung)) {
                $_SESSION['error'] = ['Nội dung bình luận không được để trống'];
                header("Location: " . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
                exit();
            }

            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            $result = $this->modelSanPham->addBinhLuan($san_pham_id, $tai_khoan_id, $noi_dung);

            if ($result) {
                $_SESSION['success'] = ['Bình luận thành công'];
            } else {
                $_SESSION['error'] = ['Bình luận thất bại'];
            }

            header("Location: " . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
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

   public function postRegister() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $ten = trim($_POST['ho_ten']);
        $email = trim($_POST['email']);
        $ngay_sinh = trim($_POST['ngay_sinh']);
        $dia_chi = trim($_POST['dia_chi']);
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];
        $sdt = trim($_POST['so_dien_thoai']);

        $errors = [];

        // validate rỗng
        if (empty($ten)) $errors[] = "Không được để trống tên";
        if (empty($email)) $errors[] = "Không được để trống email";
        if (empty($ngay_sinh)) $errors[] = "Không được để trống ngày sinh";
        if (empty($dia_chi)) $errors[] = "Không được để trống địa chỉ";
        if (empty($password)) $errors[] = "Không được để trống mật khẩu";
        if (empty($sdt)) $errors[] = "Không được để trống số điện thoại";

        // validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ";
        }

        // password
        if (strlen($password) < 6) {
            $errors[] = "Mật khẩu phải >= 6 ký tự";
        }

        if ($password !== $confirm) {
            $errors[] = "Mật khẩu nhập lại không khớp";
        }

        // check email tồn tại
        if ($this->modelTaiKhoan->checkEmailExists($email)) {
            $errors[] = "Email đã tồn tại";
        }

        // nếu lỗi
        if (!empty($errors)) {
            $_SESSION['error'] = $errors;
            header("Location: " . BASE_URL . '?act=register-form');
            exit();
        }

        // hash password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        // lưu DB
        $result = $this->modelTaiKhoan->register($ten, $email, $ngay_sinh, $dia_chi, $hashPassword, $sdt);

        // kiểm tra kết quả đăng ký
        if ($result === true) {
            // thông báo thành công
            $_SESSION['error'] = ['Đăng ký thành công! Hãy đăng nhập'];
            header("Location: " . BASE_URL . '?act=login');
            exit();
        } else {
            // thông báo lỗi
            $_SESSION['error'] = [$result];
            header("Location: " . BASE_URL . '?act=register-form');
            exit();
        }
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

            if ($user) {
                // Trường hợp đăng nhập thành công
                $_SESSION['user_client'] = $user['email'];
                header("Location: " . BASE_URL);
                exit();
            } else {
                // Lỗi thì lưu lỗi vào session
                $_SESSION['error'] = ['Email hoặc mật khẩu không đúng'];
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
            } else {
                $_SESSION['error'] = ['Bạn chưa đăng nhập!'];
                session_write_close();
                header("Location: " . BASE_URL . '?act=login');
                exit();
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
            } else {
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            require_once './views/gioHang.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    public function taiKhoan()
    {
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }

        $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
        $donHangs = $this->modelDonHang->getDonHangFromUser($user['id']);

        require_once './views/taiKhoan.php';
    }

    public function postCapNhatTaiKhoan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_client'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $userId = $user['id'];

            $ho_ten = trim($_POST['ho_ten']);
            $email = trim($_POST['email']);
            $ngay_sinh = trim($_POST['ngay_sinh']);
            $dia_chi = trim($_POST['dia_chi']);
            $so_dien_thoai = trim($_POST['so_dien_thoai']);
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $errors = [];

            // Validate
            if (empty($ho_ten)) $errors[] = "Họ tên không được để trống";
            if (empty($email)) $errors[] = "Email không được để trống";
            if (empty($dia_chi)) $errors[] = "Địa chỉ không được để trống";
            if (empty($so_dien_thoai)) $errors[] = "Số điện thoại không được để trống";

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            }

            // Check email exists for other users
            $existingUser = $this->modelTaiKhoan->getTaiKhoanFromEmail($email);
            if ($existingUser && $existingUser['id'] != $userId) {
                $errors[] = "Email đã được sử dụng bởi tài khoản khác";
            }

            // Password change validation
            if (!empty($new_password)) {
                if (empty($current_password)) {
                    $errors[] = "Vui lòng nhập mật khẩu hiện tại";
                } elseif (!password_verify($current_password, $user['mat_khau'])) {
                    $errors[] = "Mật khẩu hiện tại không đúng";
                } elseif (strlen($new_password) < 6) {
                    $errors[] = "Mật khẩu mới phải có ít nhất 6 ký tự";
                } elseif ($new_password !== $confirm_password) {
                    $errors[] = "Mật khẩu xác nhận không khớp";
                }
            }

            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header("Location: " . BASE_URL . '?act=tai-khoan');
                exit();
            }

            // Update user info
            $updateData = [
                'ho_ten' => $ho_ten,
                'email' => $email,
                'ngay_sinh' => $ngay_sinh,
                'dia_chi' => $dia_chi,
                'so_dien_thoai' => $so_dien_thoai
            ];

            if (!empty($new_password)) {
                $updateData['mat_khau'] = password_hash($new_password, PASSWORD_DEFAULT);
                $_SESSION['user_client'] = $email; // Update session if email changed
            }

            $result = $this->modelTaiKhoan->updateTaiKhoan($userId, $updateData);

            if ($result) {
                $_SESSION['success'] = ['Cập nhật tài khoản thành công'];
            } else {
                $_SESSION['error'] = ['Có lỗi xảy ra khi cập nhật tài khoản'];
            }

            header("Location: " . BASE_URL . '?act=tai-khoan');
            exit();
        }

        header("Location: " . BASE_URL . '?act=tai-khoan');
        exit();
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

    public function xoaGioHang(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_client'])) {
                $_SESSION['error'] = ['Bạn chưa đăng nhập!'];
                session_write_close();
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }

            $san_pham_id = $_POST['san_pham_id'];
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);

            if ($gioHang) {
                $this->modelGioHang->removeDetailGioHang($gioHang['id'], $san_pham_id);
            }
        }

        header("Location: " . BASE_URL . '?act=gio-hang');
        exit();
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

                // Lưu từng sản phẩm vào chi tiết đơn hàng và giảm tồn kho
                foreach ($chiTietGioHang as $item) {
                    $donGia = $item['gia_khuyen_mai'] ?? $item['gia_san_pham'];
                    $this->modelDonHang->addChiTietDonHang(
                        $donhang,
                        $item['san_pham_id'],
                        $donGia,
                        $item['so_luong'],
                        $donGia * $item['so_luong']
                    );
                    $this->modelSanPham->reduceStock($item['san_pham_id'], $item['so_luong']);
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

            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);
            foreach ($chiTietDonHang as $item) {
                $this->modelSanPham->restoreStock($item['san_pham_id'], $item['so_luong']);
            }

            // Hủy đơn hàng
            $this->modelDonHang->updateTrangThaiDonHang($donHangId, 11);
            header("Location: " . BASE_URL . '?act=lich_su_mua_hang');
            exit();
        } else {
            var_dump("Ban chua dang nhap");
            die;
        }
    }

    public function gioiThieu()
    {
        $listDanhMuc = $this->modelSanPham->getAllDanhMuc();
        $listSanPham = $this->modelSanPham->getAllSanPham();

        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $itemsPerPage = 4;
        $totalProducts = count($listSanPham);
        $totalPages = max(1, (int) ceil($totalProducts / $itemsPerPage));
        $currentPage = max(1, min($currentPage, $totalPages));

        $offset = ($currentPage - 1) * $itemsPerPage;
        $pageProducts = array_slice($listSanPham, $offset, $itemsPerPage);

        $listRecentPosts = [];
        foreach (array_slice($listSanPham, 0, 3) as $sanPham) {
            $listRecentPosts[] = [
                'url' => BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'],
                'image' => $sanPham['hinh_anh'],
                'title' => $sanPham['ten_san_pham'],
                'date' => date('d/m/Y', strtotime($sanPham['ngay_nhap']))
            ];
        }

        $listBlogPosts = [];
        foreach ($pageProducts as $sanPham) {
            $excerpt = '';
            if (!empty($sanPham['mo_ta'])) {
                $excerpt = mb_strlen($sanPham['mo_ta']) > 120 ? mb_substr($sanPham['mo_ta'], 0, 120) . '...' : $sanPham['mo_ta'];
            } else {
                $excerpt = 'Cập nhật tin tức mới về sản phẩm ' . $sanPham['ten_san_pham'] . '. Xem thêm chi tiết tại trang sản phẩm.';
            }

            $listBlogPosts[] = [
                'title' => $sanPham['ten_san_pham'],
                'url' => BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'],
                'image' => $sanPham['hinh_anh'],
                'date' => date('d/m/Y', strtotime($sanPham['ngay_nhap'])),
                'category' => $sanPham['ten_danh_muc'] ?? 'Tin tức',
                'excerpt' => $excerpt,
            ];
        }

        require_once './views/gioiThieu.php';
        exit();
    }

    public function lienHe()
    {
        require_once './views/lienHe.php';
        exit();
    }
}
