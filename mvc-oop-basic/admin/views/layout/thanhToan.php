<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>

<!-- Breadcrumb -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php"><i class="fa fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="shop.php">Shop</a>
                            </li>
                            <li class="breadcrumb-item active">Cart</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart -->
<div class="cart-main-wrapper section-padding">
    <div class="container">
        <div class="section-bg-color">
            <div class="row">

                <div class="col-lg-12">
                    <div class="cart-table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>

                            <tbody>
<?php
$tongGioHang = 0;

if (!empty($chiTietGioHang)) :
foreach ($chiTietGioHang as $key => $sanPham) :
?>
                                <tr>
                                    <!-- Ảnh -->
                                    <td>
                                        <img width="80"
                                            src="<?= BASE_URL . $sanPham['hinh_anh'] ?>">
                                    </td>

                                    <!-- Tên -->
                                    <td><?= $sanPham['ten_san_pham'] ?></td>

                                    <!-- Giá -->
                                    <td>
                                        <?php if ($sanPham['gia_khuyen_mai']) : ?>
                                            <?= formatPrice($sanPham['gia_khuyen_mai']) ?> đ
                                        <?php else : ?>
                                            <?= formatPrice($sanPham['gia_san_pham']) ?> đ
                                        <?php endif; ?>
                                    </td>

                                    <!-- Số lượng -->
                                    <td>
                                        <input type="number"
                                            value="<?= $sanPham['so_luong'] ?>">
                                    </td>

                                    <!-- Tổng -->
                                    <td>
<?php
if ($sanPham['gia_khuyen_mai']) {
    $tongTien = $sanPham['gia_khuyen_mai'] * $sanPham['so_luong'];
} else {
    $tongTien = $sanPham['gia_san_pham'] * $sanPham['so_luong'];
}

$tongGioHang += $tongTien;

echo formatPrice($tongTien) . ' đ';
?>
                                    </td>

                                    <!-- Xóa -->
                                    <td>
                                        <a href="?delete=<?= $key ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
<?php endforeach; endif; ?>
                            </tbody>

                        </table>
                    </div>

                    <!-- Coupon -->
                    <div class="cart-update-option d-flex justify-content-between">
                        <form method="post">
                            <input type="text" placeholder="Mã giảm giá">
                            <button class="btn btn-primary">Áp dụng</button>
                        </form>

                        <a href="#" class="btn btn-secondary">Cập nhật giỏ</a>
                    </div>

                </div>

                <!-- Tổng tiền -->
                <div class="col-lg-5 ml-auto">
                    <div class="cart-calculator-wrapper">
                        <h4>Tổng đơn hàng</h4>

                        <table class="table">
                            <tr>
                                <td>Tổng tiền</td>
                                <td><?= formatPrice($tongGioHang) ?> đ</td>
                            </tr>

                            <tr>
                                <td>Vận chuyển</td>
                                <td>30.000 đ</td>
                            </tr>

                            <tr>
                                <td><strong>Thanh toán</strong></td>
                                <td>
                                    <strong>
                                        <?= formatPrice($tongGioHang + 30000) ?> đ
                                    </strong>
                                </td>
                            </tr>
                        </table>

                        <a href="checkout.php" class="btn btn-success w-100">
                            Tiến hành đặt hàng
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</main>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>