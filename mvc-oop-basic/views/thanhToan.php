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
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?act=gio-hang">Giỏ hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-page-wrapper section-padding">
        <div class="container">
            <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger mb-4"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>?act=xu-ly-thanh-toan" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h5 class="checkout-title">Thông tin người nhận</h5>
                            <div class="billing-form-wrap">
                                <div class="single-input-item">
                                    <label for="ten_nguoi_nhan" class="required">Tên người nhận</label>
                                    <input type="text" id="ten_nguoi_nhan" name="ten_nguoi_nhan" value="<?= htmlspecialchars((string)($user['ho_ten'] ?? '')) ?>" required>
                                </div>

                                <div class="single-input-item">
                                    <label for="email_nguoi_nhan" class="required">Địa chỉ email</label>
                                    <input type="email" id="email_nguoi_nhan" name="email_nguoi_nhan" value="<?= htmlspecialchars((string)($user['email'] ?? '')) ?>" required>
                                </div>

                                <div class="single-input-item">
                                    <label for="sdt_nguoi_nhan" class="required">Số điện thoại</label>
                                    <input type="text" id="sdt_nguoi_nhan" name="sdt_nguoi_nhan" value="<?= htmlspecialchars((string)($user['so_dien_thoai'] ?? '')) ?>" required>
                                </div>

                                <div class="single-input-item">
                                    <label for="dia_chi_nguoi_nhan" class="required">Địa chỉ người nhận</label>
                                    <input type="text" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan" value="<?= htmlspecialchars((string)($user['dia_chi'] ?? '')) ?>" required>
                                </div>

                                <div class="single-input-item">
                                    <label for="ghi_chu">Ghi chú</label>
                                    <textarea name="ghi_chu" id="ghi_chu" cols="30" rows="3" placeholder="Ghi chú đơn hàng của bạn"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Thông tin sản phẩm</h5>
                            <div class="order-summary-content">
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $tongGioHang = 0; ?>
                                            <?php foreach ($chiTietGioHang as $sanPham) : ?>
                                                <?php
                                                $donGia = (float)($sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham']);
                                                $thanhTien = $donGia * (int)$sanPham['so_luong'];
                                                $tongGioHang += $thanhTien;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= htmlspecialchars($sanPham['ten_san_pham']) ?> <strong>x <?= (int)$sanPham['so_luong'] ?></strong>
                                                    </td>
                                                    <td><?= formatPrice($thanhTien) ?> đ</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Tổng tiền sản phẩm</td>
                                                <td><strong><?= formatPrice($tongGioHang) ?> đ</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Shipping</td>
                                                <td><strong>30.000 đ</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tổng đơn hàng</td>
                                                <td><strong><?= formatPrice($tongGioHang + 30000) ?> đ</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="order-payment-method">
                                    <div class="single-payment-method show">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon" value="1" name="phuong_thuc_thanh_toan_id" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="cashon">Thanh toán khi nhận hàng</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="cash">
                                            <p>Khách hàng có thể thanh toán sau khi đã nhận hàng thành công.</p>
                                        </div>
                                    </div>

                                    <div class="single-payment-method">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="directbank" name="phuong_thuc_thanh_toan_id" value="2" class="custom-control-input">
                                                <label class="custom-control-label" for="directbank">Thanh toán online</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="bank">
                                            <p>Khách hàng thanh toán online qua cổng thanh toán.</p>
                                        </div>
                                    </div>

                                    <div class="summary-footer-area">
                                        <div class="custom-control custom-checkbox mb-20">
                                            <input type="checkbox" class="custom-control-input" id="terms" required>
                                            <label class="custom-control-label" for="terms">Xác nhận đặt hàng</label>
                                        </div>
                                        <button type="submit" class="btn btn-sqr">Tiến hành đặt hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
