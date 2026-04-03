<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="myaccount-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="myaccount-tab-menu nav flex-column" role="tablist">
                        <a class="nav-link <?= $activeTab === 'dashboard' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=tai-khoan&tab=dashboard' ?>">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                        <a class="nav-link <?= $activeTab === 'orders' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=tai-khoan&tab=orders' ?>">
                            <i class="fa fa-cart-arrow-down"></i> Orders
                        </a>
                        <a class="nav-link <?= $activeTab === 'download' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=download' ?>">
                            <i class="fa fa-cloud-download"></i> Download
                        </a>
                        <a class="nav-link <?= $activeTab === 'payment' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=payment' ?>">
                            <i class="fa fa-credit-card"></i> Payment Method
                        </a>
                        <a class="nav-link <?= $activeTab === 'address' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=tai-khoan&tab=address' ?>">
                            <i class="fa fa-map-marker"></i> Address
                        </a>
                        <a class="nav-link <?= $activeTab === 'account' ? 'active' : '' ?>" href="<?= BASE_URL . '?act=tai-khoan&tab=account' ?>">
                            <i class="fa fa-user"></i> Account Details
                        </a>
                        <a class="nav-link" href="<?= BASE_URL . '?act=logout' ?>">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="myaccount-content">
                        <?php if (!empty($user)): ?>

                            <!-- Dashboard -->
                            <div id="dashboard" style="display: <?= $activeTab === 'dashboard' ? 'block' : 'none' ?>;">
                                <h3>Dashboard</h3>
                                <p>Xin chào <strong><?= htmlspecialchars($user['ho_ten']) ?></strong></p>
                                <p>Sản phẩm trong giỏ hàng hiện tại: <strong><?= $cartCount ?></strong></p>
                                <p>Số đơn hàng đã đặt: <strong><?= count($donHangs) ?></strong></p>
                                <div class="mt-3">
                                    <a href="<?= BASE_URL . '?act=tai-khoan&tab=orders' ?>" class="btn btn-sqr">Xem Orders</a>
                                    <a href="<?= BASE_URL . '?act=tai-khoan&tab=account' ?>" class="btn btn-sqr">Cập nhật tài khoản</a>
                                </div>
                            </div>

                            <!-- Orders -->
                            <div id="orders" style="display: <?= $activeTab === 'orders' ? 'block' : 'none' ?>;">
                                <h3>Orders</h3>
                                <?php if (!empty($donHangs)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Ngày đặt</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Phương thức</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($donHangs as $donHang): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($donHang['ma_don_hang']) ?></td>
                                                        <td><?= htmlspecialchars($donHang['ngay_dat']) ?></td>
                                                        <td><?= formatPrice($donHang['tong_tien']) ?>đ</td>
                                                        <td><?= htmlspecialchars($phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan_id']] ?? 'Chưa xác định') ?></td>
                                                        <td><?= htmlspecialchars($trangThaiDonHang[$donHang['trang_thai_id']] ?? 'Chưa xác định') ?></td>
                                                        <td><a href="<?= BASE_URL . '?act=chi_tiet_mua_hang&id=' . $donHang['id'] ?>" class="btn btn-sqr btn-sm">Chi tiết</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php elseif (!empty($cartItems)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá</th>
                                                    <th>Thành tiền</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cartItems as $item): ?>
                                                    <?php $price = $item['gia_khuyen_mai'] ?: $item['gia_san_pham']; ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                                                        <td><?= (int)$item['so_luong'] ?></td>
                                                        <td><?= formatPrice($price) ?>đ</td>
                                                        <td><?= formatPrice($price * $item['so_luong']) ?>đ</td>
                                                        <td><a href="<?= BASE_URL . '?act=gio-hang' ?>" class="btn btn-sqr btn-sm">Giỏ hàng</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">Chưa có đơn hàng nào.</div>
                                <?php endif; ?>
                            </div>

                            <!-- Download -->
                            <div id="download" style="display: <?= $activeTab === 'download' ? 'block' : 'none' ?>;">
                                <h3>Download</h3>
                                <p>Bạn có thể tải hóa đơn và tài liệu hướng dẫn tại đây.</p>
                                <ul class="list-unstyled">
                                    <li><a href="#" class="btn btn-sqr">Tải hóa đơn mới nhất</a></li>
                                    <li class="mt-2"><a href="#" class="btn btn-sqr">Tải hướng dẫn</a></li>
                                </ul>
                            </div>

                            <!-- Payment -->
                            <div id="payment" style="display: <?= $activeTab === 'payment' ? 'block' : 'none' ?>;">
                                <h3>Payment Method</h3>
                                <p>Phương thức thanh toán hiện tại:</p>
                                <ul>
                                    <li>Ngân hàng</li>
                                    <li>Tiền mặt khi nhận hàng (COD)</li>
                                </ul>
                                <a href="#" class="btn btn-sqr">Cập nhật phương thức thanh toán</a>
                            </div>

                            <!-- Address -->
                            <div id="address" style="display: <?= $activeTab === 'address' ? 'block' : 'none' ?>;">
                                <h3>Address</h3>
                                <address>
                                    <p><strong><?= htmlspecialchars($user['ho_ten']) ?></strong></p>
                                    <p><?= htmlspecialchars($user['dia_chi'] ?? 'Chưa có địa chỉ') ?></p>
                                    <p><?= htmlspecialchars($user['so_dien_thoai'] ?? 'Chưa có số điện thoại') ?></p>
                                </address>
                                <a href="<?= BASE_URL . '?act=tai-khoan&tab=account' ?>" class="btn btn-sqr">Chỉnh sửa địa chỉ</a>
                            </div>

                            <!-- Account Details -->
                            <div id="account" style="display: <?= $activeTab === 'account' ? 'block' : 'none' ?>;">
                                <h3>Account Details</h3>
                                <div class="account-details-form">
                                    <form action="<?= BASE_URL . '?act=update-tai-khoan' ?>" method="POST">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="single-input-item mb-3">
                                                    <label for="ho_ten" class="required">Họ và tên</label>
                                                    <input type="text" id="ho_ten" name="ho_ten" value="<?= htmlspecialchars($user['ho_ten'] ?? '') ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="single-input-item mb-3">
                                                    <label for="email" class="required">Email</label>
                                                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="single-input-item mb-3">
                                                    <label for="ngay_sinh">Ngày sinh</label>
                                                    <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?= htmlspecialchars($user['ngay_sinh'] ?? '') ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="single-input-item mb-3">
                                                    <label for="so_dien_thoai">Số điện thoại</label>
                                                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" value="<?= htmlspecialchars($user['so_dien_thoai'] ?? '') ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-input-item mb-3">
                                            <label for="dia_chi">Địa chỉ</label>
                                            <input type="text" id="dia_chi" name="dia_chi" value="<?= htmlspecialchars($user['dia_chi'] ?? '') ?>" class="form-control">
                                        </div>

                                        <fieldset class="border p-3 mt-4">
                                            <legend class="w-auto">Thay đổi mật khẩu</legend>
                                            <div class="single-input-item mb-3">
                                                <label for="mat_khau_hien_tai">Mật khẩu hiện tại</label>
                                                <input type="password" id="mat_khau_hien_tai" name="mat_khau_hien_tai" class="form-control" placeholder="Điền mật khẩu hiện tại nếu muốn đổi">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item mb-3">
                                                        <label for="mat_khau_moi">Mật khẩu mới</label>
                                                        <input type="password" id="mat_khau_moi" name="mat_khau_moi" class="form-control" placeholder="Mật khẩu mới">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item mb-3">
                                                        <label for="mat_khau_xac_nhan">Xác nhận mật khẩu</label>
                                                        <input type="password" id="mat_khau_xac_nhan" name="mat_khau_xac_nhan" class="form-control" placeholder="Nhập lại mật khẩu mới">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="single-input-item mt-4">
                                            <button type="submit" class="btn btn-sqr">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        <?php else: ?>
                            <div class="alert alert-warning mt-3">
                                Không tìm thấy thông tin tài khoản.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>