<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<!-- ALERT -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="custom-alert">
        <?php foreach ($_SESSION['error'] as $err): ?>
            <?= htmlspecialchars($err) ?>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<main>
    <div class="login-register-wrapper section-padding">
        <div class="container" style="max-width: 40vw">
            <div class="login-reg-form-wrap">

                <h5 class="text-center">ĐĂNG KÝ</h5>

                <form action="<?= BASE_URL . '?act=check-register' ?>" method="post">

                    <div class="single-input-item">
                        <input type="text" name="ho_ten" placeholder="Họ và tên" required>
                    </div>

                    <div class="single-input-item">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="single-input-item">
                        <input type="date" name="ngay_sinh" placeholder="Ngày sinh" required>
                    </div>

                    <div class="single-input-item">
                        <input type="text" name="dia_chi" placeholder="Địa chỉ" required>
                    </div>

                    <div class="single-input-item">
                        <input type="text" name="so_dien_thoai" placeholder="Số điện thoại" required>
                    </div>

                    <div class="single-input-item">
                        <input type="password" name="password" placeholder="Mật khẩu" required>
                    </div>

                    <div class="single-input-item">
                        <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                    </div>

                    <div class="single-input-item">
                        <button class="btn btn-sqr">Đăng ký</button>
                    </div>

                </form>

                <p class="text-center mt-2">
                    Đã có tài khoản?
                    <a href="<?= BASE_URL . '?act=login' ?>">Đăng nhập</a>
                </p>

            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/miniCart.php'; ?>
<?php require_once 'views/layout/footer.php'; ?>