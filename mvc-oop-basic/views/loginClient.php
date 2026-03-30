<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>
<?php
$redirect = isset($_GET['redirect']) ? (string)$_GET['redirect'] : '';
$oldEmail = isset($_SESSION['login_old_email']) ? (string)$_SESSION['login_old_email'] : '';
unset($_SESSION['login_old_email']);
?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Login-Register</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-register-wrapper section-padding">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap">
                            <h5>ĐĂNG NHẬP</h5>

                            <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['error'])) : ?>
                                <p class="text-danger mb-3"><?= htmlspecialchars($_SESSION['error']) ?></p>
                            <?php endif; ?>

                            <form action="<?= BASE_URL . '?act=check-login-client' ?>" method="post">
                                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
                                <div class="single-input-item">
                                    <input type="email" name="email" placeholder="Email or Username" value="<?= htmlspecialchars($oldEmail) ?>" required>
                                </div>
                                <div class="single-input-item">
                                    <input type="password" name="password" placeholder="Enter your Password" required>
                                </div>
                                <div class="single-input-item">
                                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                        <a href="#" class="forget-pwd">Quên mật khẩu</a>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <button class="btn btn-sqr" type="submit">Đăng nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
