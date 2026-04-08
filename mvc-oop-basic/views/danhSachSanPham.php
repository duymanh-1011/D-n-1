<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<?php require_once 'layout/miniCart.php'; ?>

<main>
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-area section-padding pt-0 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <aside class="sidebar-widget"> 
                        <h4 class="widget-title">Lọc sản phẩm</h4>
                        <form action="<?= BASE_URL . '?act=danh-sach-san-pham' ?>" method="GET">
                            <input type="hidden" name="act" value="danh-sach-san-pham">

                            <div class="filter-group mb-3">
                                <label>Danh mục</label>
                                <select name="danh_muc_id" class="form-control">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($listDanhMuc as $danhMuc): ?>
                                        <option value="<?= $danhMuc['id'] ?>" <?= (isset($_GET['danh_muc_id']) && $_GET['danh_muc_id']==$danhMuc['id']) ? 'selected' : '' ?>><?= htmlspecialchars($danhMuc['ten_danh_muc']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-group mb-3">
                                <label>Giá từ</label>
                                <input type="number" name="min_price" class="form-control" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" placeholder="0">
                            </div>
                            <div class="filter-group mb-3">
                                <label>Giá đến</label>
                                <input type="number" name="max_price" class="form-control" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" placeholder="0">
                            </div>
                            <button type="submit" class="btn-apply">Áp dụng</button>
                        </form>
                    </aside>
                </div>

                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Danh sách sản phẩm</h4>
                        <p class="mb-0">Tìm được <?= count($listSanPham) ?> sản phẩm</p>
                    </div>
                    <div class="row">
                        <?php if (empty($listSanPham)): ?>
                            <div class="col-12"><p>Không có sản phẩm phù hợp.</p></div>
                        <?php else: ?>
                            <?php foreach ($listSanPham as $sanPham): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm product-card">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                            <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" class="card-img-top" alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>">
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></h6>
                                            <p class="card-text mb-1"><strong>Giá</strong>:
                                                <?php if (!empty($sanPham['gia_khuyen_mai'])): ?>
                                                    <span class="text-danger"><?= formatPrice($sanPham['gia_khuyen_mai']) ?>đ</span>
                                                    <span class="text-muted"><del><?= formatPrice($sanPham['gia_san_pham']) ?>đ</del></span>
                                                <?php else: ?>
                                                    <?= formatPrice($sanPham['gia_san_pham']) ?>đ
                                                <?php endif; ?>
                                            </p>
                                            <p class="card-text text-muted"><small><?= htmlspecialchars($sanPham['ten_danh_muc']) ?></small></p>
                                            <form action="<?= BASE_URL ?>" method="GET" class="mt-auto">
                                                <input type="hidden" name="act" value="chi-tiet-san-pham">
                                                <input type="hidden" name="id_san_pham" value="<?= $sanPham['id'] ?>">
                                                <button type="submit" class="btn-detail">Xem chi tiết</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>