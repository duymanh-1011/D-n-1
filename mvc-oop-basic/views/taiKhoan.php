<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<?php require_once 'layout/miniCart.php'; ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success">
                <?php echo implode('<br>', $_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="container mt-3">
            <div class="alert alert-danger">
                <?php echo implode('<br>', $_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                            Dashboard</a>
                                        <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>
                                            Đơn hàng</a>
                                        <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i>
                                            Phương thức thanh toán</a>
                                        <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
                                            Địa chỉ</a>
                                        <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Chi tiết tài khoản</a>
                                        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->

                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Dashboard</h5>
                                                <div class="welcome">
                                                    <p>Xin chào, <strong><?php echo htmlspecialchars($user['ho_ten'] ?? 'Khách hàng'); ?></strong> (Nếu không phải bạn <a href="<?= BASE_URL . '?act=logout' ?>" class="logout"> Đăng xuất</a>)</p>
                                                </div>
                                                <p class="mb-0">Từ bảng điều khiển tài khoản của bạn, bạn có thể dễ dàng kiểm tra và xem các đơn hàng gần đây, quản lý địa chỉ giao hàng và thanh toán cũng như chỉnh sửa mật khẩu và chi tiết tài khoản của mình.</p>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Đơn hàng</h5>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Mã đơn</th>
                                                                <th>Ngày đặt</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng tiền</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($donHangs)): ?>
                                                                <?php foreach ($donHangs as $donHang): ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($donHang['ma_don_hang']); ?></td>
                                                                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($donHang['ngay_dat']))); ?></td>
                                                                        <td><?php echo htmlspecialchars($donHang['ten_trang_thai'] ?? 'Chờ xử lý'); ?></td>
                                                                        <td><?php echo formatPrice($donHang['tong_tien'] ?? 0); ?>đ</td>
                                                                        <td><a href="<?= BASE_URL . '?act=chi_tiet_mua_hang&id=' . $donHang['id'] ?>" class="btn btn-sqr">Xem</a></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="5">Chưa có đơn hàng nào.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Phương thức thanh toán</h5>
                                                <p class="saved-message">Bạn chưa lưu phương thức thanh toán nào.</p>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Địa chỉ thanh toán</h5>
                                                <address>
                                                    <p><strong><?php echo htmlspecialchars($user['ho_ten'] ?? ''); ?></strong></p>
                                                    <p><?php echo htmlspecialchars($user['dia_chi'] ?? 'Chưa cập nhật'); ?><br>
                                                        Việt Nam</p>
                                                    <p>Số điện thoại: <?php echo htmlspecialchars($user['so_dien_thoai'] ?? ''); ?></p>
                                                </address>
                                                <a href="#account-info" class="btn btn-sqr" data-bs-toggle="tab"><i class="fa fa-edit"></i>
                                                    Chỉnh sửa địa chỉ</a>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="account-info" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Chi tiết tài khoản</h5>
                                                <div class="account-details-form">
                                                    <form action="<?= BASE_URL . '?act=cap-nhat-tai-khoan' ?>" method="POST">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="ho_ten" class="required">Họ tên</label>
                                                                    <input type="text" id="ho_ten" name="ho_ten" value="<?php echo htmlspecialchars($user['ho_ten'] ?? ''); ?>" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="email" class="required">Email</label>
                                                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="ngay_sinh">Ngày sinh</label>
                                                            <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?php echo htmlspecialchars($user['ngay_sinh'] ?? ''); ?>" />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="dia_chi" class="required">Địa chỉ</label>
                                                            <input type="text" id="dia_chi" name="dia_chi" value="<?php echo htmlspecialchars($user['dia_chi'] ?? ''); ?>" required />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="so_dien_thoai" class="required">Số điện thoại</label>
                                                            <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo htmlspecialchars($user['so_dien_thoai'] ?? ''); ?>" required />
                                                        </div>
                                                        <fieldset>
                                                            <legend>Đổi mật khẩu</legend>
                                                            <div class="single-input-item">
                                                                <label for="current-pwd">Mật khẩu hiện tại</label>
                                                                <input type="password" id="current-pwd" name="current_password" placeholder="Mật khẩu hiện tại" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="new-pwd">Mật khẩu mới</label>
                                                                        <input type="password" id="new-pwd" name="new_password" placeholder="Mật khẩu mới" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="confirm-pwd">Xác nhận mật khẩu</label>
                                                                        <input type="password" id="confirm-pwd" name="confirm_password" placeholder="Xác nhận mật khẩu" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="single-input-item">
                                                            <button class="btn btn-sqr">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- Single Tab Content End -->
                                    </div>
                                </div> <!-- My Account Tab Content End -->
                            </div>
                        </div> <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
</main>

<?php require_once 'layout/footer.php'; ?>