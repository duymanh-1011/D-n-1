<!-- header  -->
<?php require './views/layout/header.php'; ?>
<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include './views/layout/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bảng điều khiển</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active">Tổng quan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= intval($tongSanPham) ?></h3>
              <p>Tổng sản phẩm</p>
            </div>
            <div class="icon">
              <i class="fas fa-tshirt"></i>
            </div>
            <a href="<?= BASE_URL_ADMIN ?>?controller=AdminSanPhamController&action=index" class="small-box-footer">Xem sản phẩm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= intval($tongDonHang) ?></h3>
              <p>Tổng đơn hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="<?= BASE_URL_ADMIN ?>?controller=AdminDonHangController&action=index" class="small-box-footer">Xem đơn hàng <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= intval($tongKhachHang) ?></h3>
              <p>Khách hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="<?= BASE_URL_ADMIN ?>?controller=AdminTaiKhoanController&action=index" class="small-box-footer">Xem khách hàng <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= number_format($tongDoanhThu, 0, ',', '.') ?>đ</h3>
              <p>Tổng doanh thu</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="<?= BASE_URL_ADMIN ?>?controller=AdminDonHangController&action=index" class="small-box-footer">Xem doanh thu <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">Lượt truy cập</h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg">820</span>
                  <span>Truy cập trong tuần</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 12.5%
                  </span>
                  <span class="text-muted">So với tuần trước</span>
                </p>
              </div>
              <div class="position-relative mb-4">
                <canvas id="visitors-chart" height="200"></canvas>
              </div>
              <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                  <i class="fas fa-square text-primary"></i> Tuần này
                </span>
                <span>
                  <i class="fas fa-square text-gray"></i> Tuần trước
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">Doanh thu</h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg"><?= number_format($tongDoanhThu, 0, ',', '.') ?>đ</span>
                  <span>Doanh thu theo tháng</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 18.4%
                  </span>
                  <span class="text-muted">So với tháng trước</span>
                </p>
              </div>
              <div class="position-relative mb-4">
                <canvas id="sales-chart" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">Sản phẩm mới nhất</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Kho</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($sanPhamMoi)): ?>
                    <?php foreach ($sanPhamMoi as $sanPham): ?>
                      <tr>
                        <td>
                          <img src="<?= BASE_URL . ltrim($sanPham['hinh_anh'] ?? './uploads/default.png', './') ?>" alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>" style="width:50px; height:50px; object-fit:cover;" onerror="this.onerror=null; this.src='https://via.placeholder.com/50'">
                        </td>
                        <td><?= htmlspecialchars($sanPham['ten_san_pham']) ?></td>
                        <td><?= number_format($sanPham['gia_san_pham'] ?? 0, 0, ',', '.') ?>đ</td>
                        <td><?= intval($sanPham['so_luong'] ?? 0) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="text-center">Chưa có sản phẩm mới</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">Đơn hàng mới</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($donHangMoi)): ?>
                    <?php foreach ($donHangMoi as $donHang): ?>
                      <tr>
                        <td><?= htmlspecialchars($donHang['ma_don_hang']) ?></td>
                        <td><?= !empty($donHang['ngay_dat']) ? date('d/m/Y', strtotime($donHang['ngay_dat'])) : '' ?></td>
                        <td><?= htmlspecialchars($donHang['ten_trang_thai']) ?></td>
                        <td><?= number_format($donHang['tong_tien'] ?? 0, 0, ',', '.') ?>đ</td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="text-center">Chưa có đơn hàng mới</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $pageScript = 'dashboard3'; ?>

<!-- Footer  -->
<?php include './views/layout/footer.php'; ?>
<!-- End footer  -->