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
                                <li class="breadcrumb-item active" aria-current="page">Bills</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['error'])) : ?>
                <div class="alert alert-info mb-3"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php endif; ?>

            <div class="section-bg-color p-4">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>Mã Đơn Hàng</th>
                                <th>Ngày Đặt</th>
                                <th>Tổng Tiền</th>
                                <th>Phương Thức Thanh Toán</th>
                                <th>Trạng Thái Đơn Hàng</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listDonHang)) : ?>
                                <?php foreach ($listDonHang as $donHang) : ?>
                                    <?php $coTheHuy = in_array((int)$donHang['trang_thai_id'], [1, 2, 3], true); ?>
                                    <tr>
                                        <td><?= htmlspecialchars($donHang['ma_don_hang']) ?></td>
                                        <td><?= htmlspecialchars((string)$donHang['ngay_dat']) ?></td>
                                        <td><?= formatPrice((float)$donHang['tong_tien']) ?> đ</td>
                                        <td><?= htmlspecialchars($donHang['ten_phuong_thuc']) ?></td>
                                        <td><?= htmlspecialchars($donHang['ten_trang_thai']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>?act=chi-tiet-don-hang&id_don_hang=<?= (int)$donHang['id'] ?>" class="btn btn-sm btn-outline-secondary">Chi tiết</a>
                                            <?php if ($coTheHuy) : ?>
                                                <form action="<?= BASE_URL ?>?act=huy-don-hang" method="post" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                                    <input type="hidden" name="id_don_hang" value="<?= (int)$donHang['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-sqr" style="margin-left: 6px;">Hủy</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">Bạn chưa có đơn hàng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
