<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['error'])) : ?>
                    <div class="alert alert-info mb-4"><?= htmlspecialchars($_SESSION['error']) ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-12">
                        <form action="<?= BASE_URL ?>?act=cap-nhat-gio-hang" method="post">
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Ảnh sản phẩm</th>
                                            <th class="pro-title">Tên sản phẩm</th>
                                            <th class="pro-price">Giá tiền</th>
                                            <th class="pro-quantity">Số lượng</th>
                                            <th class="pro-subtotal">Tổng tiền</th>
                                            <th class="pro-remove">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $tongGioHang = 0; ?>
                                        <?php if (!empty($chiTietGioHang)) : ?>
                                            <?php foreach ($chiTietGioHang as $sanPham) : ?>
                                                <?php
                                                $donGia = (float)($sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham']);
                                                $tongTien = $donGia * (int)$sanPham['so_luong'];
                                                $tongGioHang += $tongTien;
                                                ?>
                                                <tr>
                                                    <td class="pro-thumbnail"><img class="img-fluid" src="<?= htmlspecialchars(BASE_URL . $sanPham['hinh_anh']) ?>" alt="Product"></td>
                                                    <td class="pro-title"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></td>
                                                    <td class="pro-price"><span><?= formatPrice($donGia) ?> đ</span></td>
                                                    <td class="pro-quantity" style="width: 150px;">
                                                        <input type="number" min="1" name="so_luong[<?= (int)$sanPham['chi_tiet_id'] ?>]" value="<?= (int)$sanPham['so_luong'] ?>" class="form-control">
                                                    </td>
                                                    <td class="pro-subtotal"><span><?= formatPrice($tongTien) ?> đ</span></td>
                                                    <td class="pro-remove">
                                                        <a href="<?= BASE_URL ?>?act=xoa-gio-hang&chi_tiet_id=<?= (int)$sanPham['chi_tiet_id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (!empty($chiTietGioHang)) : ?>
                                <div class="cart-update-option d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-sqr">Cập nhật giỏ hàng</button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5 ms-auto">
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Tổng đơn hàng</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền sản phẩm</td>
                                            <td><?= formatPrice($tongGioHang) ?> đ</td>
                                        </tr>
                                        <tr>
                                            <td>Vận chuyển</td>
                                            <td>30.000 đ</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Tổng thanh toán</td>
                                            <td class="total-amount"><?= formatPrice($tongGioHang + 30000) ?> đ</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>?act=thanh-toan" class="btn btn-sqr d-block">Tiến hành đặt hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
