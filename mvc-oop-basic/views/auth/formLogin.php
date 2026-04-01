<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<!-- ALERT THÔNG BÁO -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="custom-alert">
        <?php foreach ($_SESSION['error'] as $err): ?>
            <?= $err ?>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<main>
    <!-- breadcrumb -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap"> 
                        <nav>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Đăng nhập</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LOGIN -->
    <div class="login-register-wrapper section-padding">
        <div class="container" style="max-width: 40vw">
            <div class="member-area-from-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-reg-form-wrap">

                            <h5 class="text-center">ĐĂNG NHẬP</h5>
                            <p class="text-center">Vui lòng đăng nhập</p>

                            <!-- FORM -->
                            <form action="<?= BASE_URL . '?act=check-login' ?>" 
                                  method="post" 
                                  autocomplete="off">

                                <!-- chống autofill -->
                                <input type="text" style="display:none">
                                <input type="password" style="display:none">

                                <div class="single-input-item">
                                    <input type="email"
                                           name="email"
                                           placeholder="Email hoặc tài khoản"
                                           autocomplete="off"
                                           required>
                                </div>

                                <div class="single-input-item">
                                    <input type="password"
                                           name="password"
                                           placeholder="Mật khẩu"
                                           autocomplete="new-password"
                                           required>
                                </div>

                                <div class="single-input-item">
                                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                        <a href="#" class="forget-pwd">Quên mật khẩu</a>
                                    </div>
                                        <div class="register-link">
                                            <span>Bạn chưa có tài khoản?</span>
                                            <a href="<?= BASE_URL . '?act=register-form' ?>">Đăng ký</a>
                                        </div>
                                </div>

                                <div class="single-input-item">
                                    <button class="btn btn-sqr">Đăng nhập</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MINICART DÙNG CHUNG -->
<?php require_once 'views/layout/miniCart.php'; ?>

<?php require_once 'views/layout/footer.php'; ?>