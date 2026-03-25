<?php

class HomeController
{
    public $modelSanPham;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
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

            if ($noiDung !== '') {
                $taiKhoanId = (int)($_SESSION['user_client']['id'] ?? 0);
                if ($taiKhoanId <= 0) {
                    $taiKhoanId = $this->modelSanPham->getDefaultTaiKhoanId();
                }

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
}
