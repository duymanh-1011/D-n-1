<?php

class HomeController
{
    public $modelSanPham;
    public $modelGioHang;
    public $modelTaiKhoan;
    
    
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelGioHang = new GioHang();
        $this->modelTaiKhoan = new TaiKhoan();
    }

    public function home()
    {
        echo "Đây là trang home của tôi";
    }
    public function trangchu()
    {
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham()
    {
        $listProduct = $this->modelSanPham->getAllProduct();
        require_once './views/listProduct.php';
    }



  public function addGioHang(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_SESSION['user_client'])) {

            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            // Lấy dữ liệu giỏ hàng của người dùng

            $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                $gioHang = ['id' => $gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

            } else {
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

            if (!$checkSanPham){
                $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
            }

            header("Location:" . BASE_URL . '?act=gio-hang');

        } else {
            var_dump('Chưa đăng nhập'); die;
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
            $gioHang = ['id' => $gioHangId];
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        } else {
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        }

        // var_dump($chiTietGioHang); die;

        require_once './views/gioHang.php';

    } else {
        var_dump('Chưa đăng nhập'); 
        die;
    }
}
     public function thanhToan() {
        require_once "./views/thanhToan.php";
     }
}
