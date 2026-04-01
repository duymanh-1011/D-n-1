<?php
require_once './models/GioHang.php';
require_once './models/TaiKhoan.php';

$chiTietGioHang = [];
$tongTien = 0;

if (isset($_SESSION['user_client'])) {
    $modelTaiKhoan = new TaiKhoan();
    $modelGioHang = new GioHang();

    $user = $modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
    $gioHang = $modelGioHang->getGioHangFromUser($user['id']);

    if ($gioHang) {
        $chiTietGioHang = $modelGioHang->getDetailGioHang($gioHang['id']);
    }
}
?>

<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>

            <div class="minicart-content-box">

                <!-- ❗ CHƯA LOGIN -->
                <?php if (!isset($_SESSION['user_client'])): ?>

                    <p style="text-align:center; padding:15px; font-weight:bold;">
                        Bạn cần đăng nhập để xem giỏ hàng
                    </p>

                <?php endif; ?>

                <!-- LIST SẢN PHẨM -->
                <div class="minicart-item-wrapper">
                    <ul>
                        <?php if (!empty($chiTietGioHang)): ?>
                            <?php foreach ($chiTietGioHang as $item): ?>
                                <?php
                                    $gia = $item['gia_khuyen_mai'] ?: $item['gia_san_pham'];
                                    $tongTien += $gia * $item['so_luong'];
                                ?>
                                <li class="minicart-item">
                                    <div class="minicart-thumb">
                                        <a href="#">
                                            <img src="<?= BASE_URL . $item['hinh_anh'] ?>" alt="">
                                        </a>
                                    </div>

                                    <div class="minicart-content">
                                        <h3 class="product-name">
                                            <a href="#"><?= $item['ten_san_pham'] ?></a>
                                        </h3>
                                        <p>
                                            <span class="cart-quantity">
                                                <?= $item['so_luong'] ?> ×
                                            </span>
                                            <span class="cart-price">
                                                <?= formatPrice($gia) ?>đ
                                            </span>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="padding:10px">Giỏ hàng trống</p>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- TỔNG TIỀN -->
                <div class="minicart-pricing-box">
                    <ul>
                        <li>
                            <span>Tạm tính</span>
                            <span><strong><?= formatPrice($tongTien) ?>đ</strong></span>
                        </li>

                        <li>
                            <span>Vận chuyển</span>
                            <span><strong>30.000đ</strong></span>
                        </li>

                        <li class="total">
                            <span>Tổng giá</span>
                            <span>
                                <strong><?= formatPrice($tongTien + 30000) ?>đ</strong>
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- BUTTON -->
                <div class="minicart-button">

                    <?php if (isset($_SESSION['user_client'])): ?>

                        <!-- ✅ ĐÃ LOGIN -->
                        <a href="<?= BASE_URL . '?act=gio-hang' ?>">
                            <i class="fa fa-shopping-cart"></i> Xem giỏ hàng
                        </a>

                        <a href="<?= BASE_URL . '?act=thanh-toan' ?>">
                            <i class="fa fa-share"></i> Thanh toán
                        </a>

                    <?php else: ?>

                        <!-- ❗ CHƯA LOGIN → ĐI QUA CONTROLLER -->
                        <a href="<?= BASE_URL . '?act=check-login-cart' ?>">
                            <i class="fa fa-shopping-cart"></i> Xem giỏ hàng
                        </a>

                        <a href="<?= BASE_URL . '?act=check-login-cart' ?>">
                            <i class="fa fa-share"></i> Thanh toán
                        </a>

                    <?php endif; ?> 

                </div>

            </div>
        </div>
    </div>
</div>