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
                                <li class="breadcrumb-item">Shop</li>
                                <li class="breadcrumb-item active" aria-current="page">Bill Detail</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="section-bg-color p-3">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center">Thông Tin Sản Phẩm</th>
                                </tr>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($listSanPhamDonHang)) : ?>
                                    <?php foreach ($listSanPhamDonHang as $item) : ?>
                                        <tr>
                                            <td style="width: 100px;">
                                                <img src="<?= htmlspecialchars(BASE_URL . ($item['hinh_anh'] ?? 'assets/img/product/product-1.jpg')) ?>" alt="sp" style="max-width:80px;">
                                            </td>
                                            <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                                            <td><?= formatPrice((float)$item['don_gia']) ?> đ</td>
                                            <td><?= (int)$item['so_luong'] ?></td>
                                            <td><?= formatPrice((float)$item['thanh_tien']) ?> đ</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr><td colspan="5" class="text-center">Không có sản phẩm trong đơn hàng.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="section-bg-color p-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Thông Tin Đơn Hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Mã đơn hàng:</td><td><?= htmlspecialchars($donHang['ma_don_hang']) ?></td></tr>
                                <tr><td>Người nhận:</td><td><?= htmlspecialchars($donHang['ten_nguoi_nhan']) ?></td></tr>
                                <tr><td>Email:</td><td><?= htmlspecialchars($donHang['email_nguoi_nhan']) ?></td></tr>
                                <tr><td>Số điện thoại:</td><td><?= htmlspecialchars($donHang['sdt_nguoi_nhan']) ?></td></tr>
                                <tr><td>Địa chỉ:</td><td><?= htmlspecialchars($donHang['dia_chi_nguoi_nhan']) ?></td></tr>
                                <tr><td>Ngày đặt:</td><td><?= htmlspecialchars((string)$donHang['ngay_dat']) ?></td></tr>
                                <tr><td>Ghi chú:</td><td><?= htmlspecialchars((string)($donHang['ghi_chu'] ?? '')) ?></td></tr>
                                <tr><td>Tổng tiền:</td><td><?= formatPrice((float)$donHang['tong_tien']) ?> đ</td></tr>
                                <tr><td>Phương thức thanh toán:</td><td><?= htmlspecialchars($donHang['ten_phuong_thuc']) ?></td></tr>
                                <tr><td>Trạng thái đơn hàng:</td><td><?= htmlspecialchars($donHang['ten_trang_thai']) ?></td></tr>
                            </tbody>
                        </table>

                        <a class="btn btn-sqr" href="<?= BASE_URL ?>?act=lich-su-mua-hang">Quay lại lịch sử mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
