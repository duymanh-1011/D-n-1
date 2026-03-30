<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<main>
    <div class="container pt-5">
        <div class="card" style="max-width: 700px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h4>Thông tin tài khoản</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($user)): ?>
                    <table class="table table-bordered">
                        <tr><th>Họ tên</th><td><?= htmlspecialchars($user['ho_ten']) ?></td></tr>
                        <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
                        <tr><th>Ngày sinh</th><td><?= htmlspecialchars($user['ngay_sinh'] ?? '') ?></td></tr>
                        <tr><th>Địa chỉ</th><td><?= htmlspecialchars($user['dia_chi'] ?? '') ?></td></tr>
                        <tr><th>Số điện thoại</th><td><?= htmlspecialchars($user['so_dien_thoai']) ?></td></tr>
                        <tr><th>Chức vụ</th><td><?= htmlspecialchars($user['chuc_vu_id']) ?></td></tr>
                        <tr><th>Trạng thái</th><td><?= htmlspecialchars($user['trang_thai']) ?></td></tr>
                    </table>
                    <a href="<?= BASE_URL . '?act=lich_su_mua_hang' ?>" class="btn btn-info">Xem lịch sử mua hàng</a>
                <?php else: ?>
                    <div class="alert alert-warning">Không tìm thấy thông tin tài khoản.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>