<?php
class AdminBaoCaoThongKeController
{
    public function home()
    {
        $modelSanPham = new AdminSanPham();
        $modelDonHang = new AdminDonHang();
        $modelTaiKhoan = new AdminTaiKhoan();

        $tongSanPham = $modelSanPham->countSanPham();
        $tongDonHang = $modelDonHang->countDonHang();
        $tongKhachHang = $modelTaiKhoan->countKhachHang();
        $tongDoanhThu = $modelDonHang->getTotalDoanhThu();
        $sanPhamMoi = $modelSanPham->getLatestSanPham(4);
        $donHangMoi = $modelDonHang->getDonHangMoiNhat(5);

        require_once './views/home.php';
    }
}